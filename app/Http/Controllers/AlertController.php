<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alert;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlertController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $properties = Property::all();
        } else {
            $properties = $user->properties()->get();
        }

        $alerts = Alert::whereIn('property_id', $properties->pluck('id'))
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('alerts.index', compact('alerts', 'properties'));
    }

    public function updateThresholds(Request $request, Property $property)
    {
        if ($property->user_id !== Auth::id() && Auth::user()->role !== 'admin') abort(403);

        $validated = $request->validate([
            'water_threshold'       => 'nullable|numeric|min:0',
            'electricity_threshold' => 'nullable|numeric|min:0',
        ]);

        $property->update($validated);

        return redirect()->back()->with('success', 'Thresholds saved successfully!');
    }

    public function markAsRead(Alert $alert)
    {
        if ($alert->property->user_id !== Auth::id() && Auth::user()->role !== 'admin') abort(403);
        $alert->update(['is_read' => true]);
        return redirect()->back();
    }

    /**
     * Run threshold checks in-app (no CLI needed).
     */
    public function checkNow()
    {
        $user = Auth::user();
        $properties = $user->role === 'admin' ? Property::all() : $user->properties()->get();

        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();
        $triggered = 0;

        foreach ($properties as $property) {
            // Water
            if ($property->water_threshold) {
                $consumed = DB::table('water_readings')
                    ->where('property_id', $property->id)
                    ->whereBetween('reading_date', [$start, $end])
                    ->sum('units_consumed');

                if ($consumed > $property->water_threshold) {
                    $msg = "⚠️ High Water Usage: {$property->name} consumed {$consumed} units this month (threshold: {$property->water_threshold}).";
                    Alert::firstOrCreate(
                        ['property_id' => $property->id, 'message' => $msg],
                        ['is_read' => false]
                    );
                    $triggered++;
                }
            }

            // Electricity
            if ($property->electricity_threshold) {
                $consumed = DB::table('electricity_readings')
                    ->where('property_id', $property->id)
                    ->whereBetween('reading_date', [$start, $end])
                    ->sum('units_consumed');

                if ($consumed > $property->electricity_threshold) {
                    $msg = "⚡ High Electricity Usage: {$property->name} consumed {$consumed} kWh this month (threshold: {$property->electricity_threshold}).";
                    Alert::firstOrCreate(
                        ['property_id' => $property->id, 'message' => $msg],
                        ['is_read' => false]
                    );
                    $triggered++;
                }
            }
        }

        $msg = $triggered > 0
            ? "{$triggered} threshold(s) exceeded — alerts have been logged!"
            : "All usage is within threshold limits. No alerts triggered.";

        return redirect()->route('alerts.index')->with('success', $msg);
    }
}
