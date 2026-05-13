<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Garage;
use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = Subscription::with(['garage', 'plan'])->paginate(10);
        return view('subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $garages = Garage::all();
        $plans = Plan::all();
        return view('subscriptions.create', compact('garages', 'plans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'garage_id' => 'required|exists:garages,id',
            'plan_id' => 'required|exists:plans,id',
            'billing_cycle' => 'required|string|in:monthly,yearly',
            'amount' => 'required|numeric|min:0',
            'starts_at' => 'required|date',
            'expires_at' => 'required|date|after:starts_at',
            'status' => 'required|string|in:active,inactive,cancelled',
            'payment_gateway' => 'nullable|string',
        ]);

        Subscription::create($validated);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        return view('subscriptions.show', compact('subscription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        $garages = Garage::all();
        $plans = Plan::all();
        return view('subscriptions.edit', compact('subscription', 'garages', 'plans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'garage_id' => 'required|exists:garages,id',
            'plan_id' => 'required|exists:plans,id',
            'billing_cycle' => 'required|string|in:monthly,yearly',
            'amount' => 'required|numeric|min:0',
            'starts_at' => 'required|date',
            'expires_at' => 'required|date|after:starts_at',
            'status' => 'required|string|in:active,inactive,cancelled',
            'payment_gateway' => 'nullable|string',
        ]);

        $subscription->update($validated);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('subscriptions.index')->with('success', 'Subscription deleted successfully.');
    }
}
