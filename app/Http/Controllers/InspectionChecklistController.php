<?php

namespace App\Http\Controllers;

use App\Models\InspectionChecklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspectionChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checklists = InspectionChecklist::withCount('items')->get();
        return view('inspection_checklists.index', compact('checklists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inspection_checklists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.category' => 'nullable|string|max:255',
        ]);

        $garageId = Auth::user()->garage_id ?? 1;

        $checklist = InspectionChecklist::create([
            'garage_id' => $garageId,
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        if ($request->has('items')) {
            foreach ($request->items as $index => $item) {
                $checklist->items()->create([
                    'item_name' => $item['item_name'],
                    'category' => $item['category'] ?? null,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('inspection-checklists.index')->with('success', 'Inspection Checklist created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InspectionChecklist $inspectionChecklist)
    {
        $inspectionChecklist->load('items');
        return view('inspection_checklists.show', compact('inspectionChecklist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspectionChecklist $inspectionChecklist)
    {
        $inspectionChecklist->load('items');
        return view('inspection_checklists.edit', compact('inspectionChecklist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InspectionChecklist $inspectionChecklist)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.category' => 'nullable|string|max:255',
        ]);

        $inspectionChecklist->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Sync items
        $inspectionChecklist->items()->delete();
        if ($request->has('items')) {
            foreach ($request->items as $index => $item) {
                $inspectionChecklist->items()->create([
                    'item_name' => $item['item_name'],
                    'category' => $item['category'] ?? null,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('inspection-checklists.index')->with('success', 'Inspection Checklist updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InspectionChecklist $inspectionChecklist)
    {
        $inspectionChecklist->delete();
        return redirect()->route('inspection-checklists.index')->with('success', 'Inspection Checklist deleted successfully.');
    }
}
