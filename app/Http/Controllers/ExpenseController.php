<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Garage;
use App\Http\Requests\StoreExpenseRequest;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('garage')->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $garages = Garage::all();
        return view('expenses.create', compact('garages'));
    }

    public function store(StoreExpenseRequest $request)
    {
        Expense::create($request->validated());

        return redirect()->route('expenses.index')->with('success', 'Expense recorded successfully.');
    }
}
