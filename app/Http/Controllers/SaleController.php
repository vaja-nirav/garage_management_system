<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Garage;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['customer', 'garage'])->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all();
        $garages = Garage::all();
        return view('sales.create', compact('customers', 'garages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'garage_id' => 'required|exists:garages,id',
            'customer_id' => 'required|exists:customers,id',
            'sale_number' => 'required|unique:sales',
            'sale_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'net_amount' => 'required|numeric',
        ]);

        Sale::create($validated);

        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
    }
}
