<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin') abort(403);
        
        $tariffs = \App\Models\Tariff::all();
        return view('tariffs.index', compact('tariffs'));
    }

    public function edit(\App\Models\Tariff $tariff)
    {
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin') abort(403);
        return view('tariffs.edit', compact('tariff'));
    }

    public function update(Request $request, \App\Models\Tariff $tariff)
    {
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin') abort(403);
        $validated = $request->validate([
            'rate_per_unit' => 'required|numeric|min:0'
        ]);
        $tariff->update($validated);
        return redirect()->route('tariffs.index')->with('success', 'Tariff updated correctly!');
    }
}
