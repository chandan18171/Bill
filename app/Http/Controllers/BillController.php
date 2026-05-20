<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Property;
use App\Services\BillCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Auth::user()->properties()->pluck('id');
        $bills = Bill::whereIn('property_id', $properties)
            ->with('property')
            ->orderBy('billing_date', 'desc')
            ->get();
        return view('bills.index', compact('bills'));
    }

    public function generate(Request $request, BillCalculator $calculator)
    {
        $request->validate(['property_id' => 'required|exists:properties,id']);
        $property = Property::findOrFail($request->property_id);
        if ($property->user_id !== Auth::id()) abort(403);

        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();

        $waterUnits = DB::table('water_readings')
            ->where('property_id', $property->id)
            ->whereBetween('reading_date', [$start, $end])
            ->sum('units_consumed');

        $elecUnits = DB::table('electricity_readings')
            ->where('property_id', $property->id)
            ->whereBetween('reading_date', [$start, $end])
            ->sum('units_consumed');

        $generated = 0;
        if ($waterUnits > 0) { $calculator->generateBill($property, 'water', $waterUnits); $generated++; }
        if ($elecUnits  > 0) { $calculator->generateBill($property, 'electricity', $elecUnits);  $generated++; }

        if ($generated === 0) {
            return redirect()->route('bills.index')->with('error', 'No readings found for this month. Log readings first before generating a bill.');
        }

        return redirect()->route('bills.index')->with('success', "{$generated} bill(s) generated successfully for {$property->name}!");
    }

    public function show(\App\Models\Bill $bill)
    {
        if ($bill->property->user_id !== \Illuminate\Support\Facades\Auth::id()) abort(403);
        
        $tax = $bill->amount - ($bill->amount / 1.05);
        $subtotal = $bill->amount - $tax;
        
        return view('bills.show', compact('bill', 'tax', 'subtotal'));
    }

    public function updateStatus(\App\Models\Bill $bill)
    {
        if ($bill->property->user_id !== \Illuminate\Support\Facades\Auth::id()) abort(403);
        
        $bill->update(['status' => 'paid']);
        return redirect()->back()->with('success', 'Bill marked as paid');
    }

    public function downloadPdf(\App\Models\Bill $bill)
    {
        if ($bill->property->user_id !== \Illuminate\Support\Facades\Auth::id()) abort(403);
        
        $tax = $bill->amount - ($bill->amount / 1.05);
        $subtotal = $bill->amount - $tax;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bills.pdf', compact('bill', 'tax', 'subtotal'));
        return $pdf->download("bill-{$bill->id}.pdf");
    }
}
