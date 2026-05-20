<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = \Illuminate\Support\Facades\Auth::user()->properties()->get();
        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        return view('properties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'meter_number' => 'required|string|unique:properties',
        ]);
        \Illuminate\Support\Facades\Auth::user()->properties()->create($validated);
        return redirect()->route('properties.index')->with('success', 'Property successfully added');
    }

    public function show(\App\Models\Property $property)
    {
        //
    }

    public function edit(\App\Models\Property $property)
    {
        $this->authorizeProperty($property);
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, \App\Models\Property $property)
    {
        $this->authorizeProperty($property);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'meter_number' => 'required|string|unique:properties,meter_number,' . $property->id,
        ]);
        $property->update($validated);
        return redirect()->route('properties.index')->with('success', 'Property updated');
    }

    public function destroy(\App\Models\Property $property)
    {
        $this->authorizeProperty($property);
        $property->delete();
        return redirect()->route('properties.index')->with('success', 'Property deleted');
    }

    private function authorizeProperty($property) {
        if ($property->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }
    }
}
