<?php

namespace App\Http\Controllers;

use App\Models\WaterReading;
use Illuminate\Http\Request;

class WaterReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = \Illuminate\Support\Facades\Auth::user()->properties()->pluck('id');
        $readings = \App\Models\WaterReading::whereIn('property_id', $properties)->with('property')->orderBy('reading_date', 'desc')->get();
        return view('water-readings.index', compact('readings'));
    }

    public function create()
    {
        $properties = \Illuminate\Support\Facades\Auth::user()->properties;
        return view('water-readings.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'reading_date' => 'required|date|before_or_equal:today',
            'previous_value' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|gte:previous_value',
            'unit_type' => 'required|in:litres,cubic m',
        ]);

        $validated['units_consumed'] = $validated['current_value'] - $validated['previous_value'];
        \App\Models\WaterReading::create($validated);
        
        return redirect()->route('water-readings.index')->with('success', 'Water reading logged successfully.');
    }

    public function show(\App\Models\WaterReading $waterReading) {}
    public function edit(\App\Models\WaterReading $waterReading) {}
    public function update(Request $request, \App\Models\WaterReading $waterReading) {}
    public function destroy(\App\Models\WaterReading $waterReading) {}
}
