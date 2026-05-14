<?php

namespace App\Http\Controllers;

use App\Models\ServiceJobCard;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Staff;   
use App\Models\Garage;
use App\Models\Sale;
use App\Models\Payment;
use App\Models\ServiceJobCardItem;
use App\Models\SaleItem;
use App\Models\Product;
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
        $jobCard->load(['customer', 'vehicle', 'staff', 'garage', 'sales.items.product', 'items.product']);
        
        // Sum of both existing sales (if any) and staged items
        $existingSalesTotal = $jobCard->sales->sum(function($sale) {
            return $sale->items->sum('total');
        });
        
        $stagedItemsTotal = $jobCard->items->sum('total');
        $grandTotal = $existingSalesTotal + $stagedItemsTotal;

        return view('job-cards.show', compact('jobCard', 'grandTotal', 'stagedItemsTotal'));
    }

    public function addItem(\Illuminate\Http\Request $request, ServiceJobCard $jobCard)
    {
        $request->validate([
            'items' => 'required|array',
        ]);

        // Pre-check stock for all items
        foreach ($request->items as $itemData) {
            $product = Product::findOrFail($itemData['id']);
            $quantity = $itemData['qty'] ?? 1;

            if ($product->track_stock && $product->quantity < $quantity) {
                return back()->with('error', "Stock Alert: {$product->name} has insufficient stock. Available: {$product->quantity}, Requested: {$quantity}. Please purchase more stock before adding to job.");
            }
        }

        // If all items pass stock check, proceed to add
        foreach ($request->items as $itemData) {
            $product = Product::findOrFail($itemData['id']);
            $quantity = $itemData['qty'] ?? 1;
            $unitPrice = $product->selling_price;
            $total = $quantity * $unitPrice;

            ServiceJobCardItem::create([
                'service_job_card_id' => $jobCard->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total' => $total,
            ]);
        }

        return back()->with('success', 'Parts added to job card successfully.');
    }

    public function destroyItem(ServiceJobCardItem $item)
    {
        $item->delete();
        return back()->with('success', 'Item removed from job card successfully.');
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
            // 1. Check if there are staged items to create a sale
            $stagedItems = $jobCard->items;
            
            if ($stagedItems->count() > 0) {
                $totalAmount = $stagedItems->sum('total');
                $taxAmount = 0; // Can be expanded to include tax logic
                $netAmount = $totalAmount + $taxAmount;

                // Create the formal Sale
                $sale = Sale::create([
                    'garage_id' => $jobCard->garage_id,
                    'customer_id' => $jobCard->customer_id,
                    'service_job_card_id' => $jobCard->id,
                    'sale_number' => 'INV-JOB-' . $jobCard->id . '-' . strtoupper(uniqid()),
                    'sale_date' => now(),
                    'total_amount' => $totalAmount,
                    'tax_amount' => $taxAmount,
                    'net_amount' => $netAmount,
                    'payment_status' => 'paid', // Mark as paid since we are collecting payment now
                    'paid_amount' => $netAmount,
                    'notes' => 'Automatic sale generated from Job Card: ' . $jobCard->job_card_number
                ]);

                foreach ($stagedItems as $item) {
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'total' => $item->total,
                    ]);

                    // Deduct Stock
                    if ($item->product->track_stock) {
                        $item->product->decrement('quantity', $item->quantity);
                    }
                }

                // Delete staged items after conversion
                $jobCard->items()->delete();
                
                // Create a formal Payment Record for this specific new sale
                Payment::create([
                    'garage_id' => $jobCard->garage_id,
                    'paymentable_type' => Sale::class,
                    'paymentable_id' => $sale->id,
                    'payment_date' => now(),
                    'amount' => $netAmount,
                    'payment_method' => $request->payment_method ?? 'cash',
                    'notes' => 'Final payment for Job Card: ' . $jobCard->job_card_number
                ]);
            }

            // 2. Process any EXISTING related Sales (that might have been added before this change)
            foreach ($jobCard->sales as $sale) {
                if ($sale->payment_status !== 'paid') {
                    $sale->update([
                        'payment_status' => 'paid',
                        'paid_amount' => $sale->net_amount,
                    ]);

                    Payment::create([
                        'garage_id' => $jobCard->garage_id,
                        'paymentable_type' => Sale::class,
                        'paymentable_id' => $sale->id,
                        'payment_date' => now(),
                        'amount' => $sale->net_amount,
                        'payment_method' => $request->payment_method ?? 'cash',
                        'notes' => 'Payment for existing sale on Job Card: ' . $jobCard->job_card_number
                    ]);
                }
            }

            // 3. Update Job Card Status to Delivered
            $jobCard->update([
                'status' => 'delivered',
                'work_done' => $request->work_done ?? $jobCard->work_done,
                'out_date' => now()
            ]);

            DB::commit();
            return redirect()->route('job-cards.index')->with('success', 'Sale generated, payment collected, and vehicle delivered successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }
}
