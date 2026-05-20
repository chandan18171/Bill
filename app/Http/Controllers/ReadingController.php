<?php

namespace App\Http\Controllers;

use App\Models\Reading;
use Illuminate\Http\Request;

class ReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $readings = \App\Models\Reading::with('meter.user')->get();
        return view('readings.index', compact('readings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $meters = \Illuminate\Support\Facades\Auth::user()->role === 'admin' 
            ? \App\Models\Meter::all() 
            : \Illuminate\Support\Facades\Auth::user()->meters;
        return view('readings.create', compact('meters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'meter_id' => 'required|exists:meters,id',
            'reading_date' => 'required|date',
            'previous_value' => 'required|numeric',
            'current_value' => 'required|numeric|gte:previous_value',
        ]);
        
        $validated['units_consumed'] = $validated['current_value'] - $validated['previous_value'];
        $reading = \App\Models\Reading::create($validated);
        
        \App\Models\Invoice::create([
            'user_id' => $reading->meter->user_id,
            'reading_id' => $reading->id,
            'amount_due' => $validated['units_consumed'] * 0.15,
            'status' => 'unpaid'
        ]);
        
        return redirect()->route('readings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reading $reading)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reading $reading)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reading $reading)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reading $reading)
    {
        //
    }
}
