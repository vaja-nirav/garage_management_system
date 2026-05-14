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

    public function edit(Expense $expense)
    {
        $garages = Garage::all();
        return view('expenses.edit', compact('expense', 'garages'));
    }

    public function update(StoreExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->validated());

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
