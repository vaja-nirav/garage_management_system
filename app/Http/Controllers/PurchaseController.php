<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Garage;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'garage'])->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $garages = Garage::all();
        return view('purchases.create', compact('suppliers', 'garages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'garage_id' => 'required|exists:garages,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_number' => 'required|unique:purchases',
            'purchase_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        Purchase::create($validated);

        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
    }
}
