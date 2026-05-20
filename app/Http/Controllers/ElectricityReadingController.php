<?php

namespace App\Http\Controllers;

use App\Models\ElectricityReading;
use Illuminate\Http\Request;

class ElectricityReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = \Illuminate\Support\Facades\Auth::user()->properties()->pluck('id');
        $readings = \App\Models\ElectricityReading::whereIn('property_id', $properties)->with('property')->orderBy('reading_date', 'desc')->get();
        return view('electricity-readings.index', compact('readings'));
    }

    public function create()
    {
        $properties = \Illuminate\Support\Facades\Auth::user()->properties;
        return view('electricity-readings.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'reading_date' => 'required|date|before_or_equal:today',
            'previous_value' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|gte:previous_value',
            'is_peak' => 'boolean',
        ]);

        $validated['is_peak'] = $request->boolean('is_peak');   
        $validated['units_consumed'] = $validated['current_value'] - $validated['previous_value'];
        
        \App\Models\ElectricityReading::create($validated);
        return redirect()->route('electricity-readings.index')->with('success', 'Electricity reading logged successfully.');
    }

    public function show(\App\Models\ElectricityReading $electricityReading) {}
    public function edit(\App\Models\ElectricityReading $electricityReading) {}
    public function update(Request $request, \App\Models\ElectricityReading $electricityReading) {}
    public function destroy(\App\Models\ElectricityReading $electricityReading) {}
}
