<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Garage;
use App\Http\Requests\StoreSupplierRequest;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::with('garage')->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        $garages = Garage::all();
        return view('suppliers.create', compact('garages'));
    }

    public function store(StoreSupplierRequest $request)
    {
        Supplier::create($request->validated());
        return redirect()->route('suppliers.index')->with('success', 'Supplier created.');
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        $garages = Garage::all();
        return view('suppliers.edit', compact('supplier', 'garages'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'garage_id' => 'required|exists:garages,id',
            'supplier_code' => 'required|unique:suppliers,supplier_code,' . $supplier->id,
            'company_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'gst_number' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
        ]);
        $supplier->update($validated);
        return redirect()->route('suppliers.index')->with('success', 'Supplier updated.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted.');
    }
}
