<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use Illuminate\Http\Request;

class MeterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meters = \Illuminate\Support\Facades\Auth::user()->role === 'admin' 
            ? \App\Models\Meter::with('user')->get() 
            : \Illuminate\Support\Facades\Auth::user()->meters;
        return view('meters.index', compact('meters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('meters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:water,electricity',
            'meter_number' => 'required|string|unique:meters',
        ]);
        
        \Illuminate\Support\Facades\Auth::user()->meters()->create($validated);
        return redirect()->route('meters.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Meter $meter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meter $meter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meter $meter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meter $meter)
    {
        //
    }
}
