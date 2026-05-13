<?php

namespace App\Http\Controllers;

use App\Models\Garage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GarageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $garages = Garage::paginate(10);
        return view('garages.index', compact('garages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('garages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_name' => 'required|string|max:255',
            'garage_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'gst_number' => 'nullable|string|max:50',
            'pan_number' => 'nullable|string|max:50',
            'business_type' => 'nullable|string|max:100',
            'established_year' => 'nullable|string|max:4',
            'employee_count' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['garage_name']) . '-' . uniqid();

        Garage::create($validated);

        return redirect()->route('garages.index')->with('success', 'Garage created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Garage $garage)
    {
        return view('garages.show', compact('garage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Garage $garage)
    {
        return view('garages.edit', compact('garage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Garage $garage)
    {
        $validated = $request->validate([
            'owner_name' => 'required|string|max:255',
            'garage_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'gst_number' => 'nullable|string|max:50',
            'pan_number' => 'nullable|string|max:50',
            'business_type' => 'nullable|string|max:100',
            'established_year' => 'nullable|string|max:4',
            'employee_count' => 'nullable|integer|min:0',
        ]);

        if ($request->garage_name !== $garage->garage_name) {
            $validated['slug'] = Str::slug($validated['garage_name']) . '-' . uniqid();
        }

        $garage->update($validated);

        return redirect()->route('garages.index')->with('success', 'Garage updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Garage $garage)
    {
        $garage->delete();
        return redirect()->route('garages.index')->with('success', 'Garage deleted successfully.');
    }
}
