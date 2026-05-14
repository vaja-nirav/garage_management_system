<?php

namespace App\Http\Controllers;

use App\Models\ServiceJobCard;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Staff;   
use App\Models\Garage;
use App\Models\Sale;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreJobCardRequest;

class ServiceJobCardController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $search = $request->input('search');

        $jobCards = ServiceJobCard::with(['customer', 'vehicle', 'staff', 'garage'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                })->orWhereHas('vehicle', function ($q) use ($search) {
                    $q->where('registration_number', 'like', "%{$search}%");
                })->orWhere('job_card_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('job-cards.index', compact('jobCards'));
    }

    public function create()
    {
        $customers = Customer::all();
        $vehicles = Vehicle::all();
        $staff = Staff::all();
        $garages = Garage::all();
        return view('job-cards.create', compact('customers', 'vehicles', 'staff', 'garages'));
    }

    public function store(StoreJobCardRequest $request)
    {
        ServiceJobCard::create($request->validated());

        return redirect()->route('job-cards.index')->with('success', 'Job Card created successfully.');
    }

    public function show(ServiceJobCard $jobCard)
    {
        $jobCard->load(['customer', 'vehicle', 'staff', 'garage', 'sales.items.product']);
        
        $grandTotal = $jobCard->sales->sum(function($sale) {
            return $sale->items->sum('total');
        });

        return view('job-cards.show', compact('jobCard', 'grandTotal'));
    }

    public function edit(ServiceJobCard $jobCard)
    {
        $customers = Customer::all();
        $vehicles = Vehicle::all();
        $staff = Staff::all();
        $garages = Garage::all();
        return view('job-cards.edit', compact('jobCard', 'customers', 'vehicles', 'staff', 'garages'));
    }

    public function update(\Illuminate\Http\Request $request, ServiceJobCard $jobCard)
    {
        $jobCard->update($request->all());
        return redirect()->route('job-cards.show', $jobCard->id)->with('success', 'Job Card updated successfully.');
    }

    public function checkout(\Illuminate\Http\Request $request, ServiceJobCard $jobCard)
    {
        DB::beginTransaction();
        try {
            // 1. Update Job Card Status to Delivered
            $jobCard->update([
                'status' => 'delivered',
                'work_done' => $request->work_done ?? $jobCard->work_done
            ]);

            // 2. Process all related Sales
            foreach ($jobCard->sales as $sale) {
                // Mark Sale as Paid
                $sale->update([
                    'payment_status' => 'paid',
                    'paid_amount' => $sale->net_amount,
                ]);

                // 3. Create a formal Payment Record
                Payment::create([
                    'garage_id' => $jobCard->garage_id,
                    'paymentable_type' => Sale::class,
                    'paymentable_id' => $sale->id,
                    'payment_date' => now(),
                    'amount' => $sale->net_amount,
                    'payment_method' => $request->payment_method ?? 'cash',
                    'notes' => 'Final payment for Job Card: ' . $jobCard->job_card_number
                ]);
            }

            DB::commit();
            return redirect()->route('job-cards.index')->with('success', 'Payment collected and vehicle delivered successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }
}
