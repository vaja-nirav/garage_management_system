<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Garage;
use App\Models\Product;
use App\Models\ServiceJobCard;
use App\Models\ServiceJobCardItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $quotations = Quotation::with(['customer', 'vehicle'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                })->orWhere('quotation_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('quotations.index', compact('quotations'));
    }

    public function create()
    {
        $customers = Customer::all();
        $vehicles = Vehicle::all();
        $products = Product::where('status', 1)->get();
        return view('quotations.create', compact('customers', 'vehicles', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'quotation_date' => 'required|date',
            'valid_until' => 'nullable|date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $totalTax = 0;

            foreach ($request->items as $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];
                $taxRate = $item['tax_rate'] ?? 0;
                $lineTax = $lineTotal * ($taxRate / 100);
                
                $totalAmount += $lineTotal;
                $totalTax += $lineTax;
            }

            $netAmount = $totalAmount + $totalTax;

            $quotation = Quotation::create([
                'garage_id' => auth()->user()->garage_id ?? 1, // Fallback if admin
                'customer_id' => $request->customer_id,
                'vehicle_id' => $request->vehicle_id,
                'quotation_number' => 'QT-' . strtoupper(uniqid()),
                'quotation_date' => $request->quotation_date,
                'valid_until' => $request->valid_until,
                'total_amount' => $totalAmount,
                'tax_amount' => $totalTax,
                'net_amount' => $netAmount,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            foreach ($request->items as $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $item['product_id'] ?? null,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'tax_rate' => $item['tax_rate'] ?? 0,
                    'total' => $lineTotal,
                ]);
            }

            DB::commit();
            return redirect()->route('quotations.index')->with('success', 'Quotation created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create quotation: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Quotation $quotation)
    {
        $quotation->load(['customer', 'vehicle', 'items.product']);
        return view('quotations.show', compact('quotation'));
    }

    public function edit(Quotation $quotation)
    {
        if ($quotation->status === 'converted') {
            return redirect()->route('quotations.index')->with('error', 'Converted quotations cannot be edited.');
        }

        $customers = Customer::all();
        $vehicles = Vehicle::all();
        $products = Product::where('status', 1)->get();
        $quotation->load('items');

        return view('quotations.edit', compact('quotation', 'customers', 'vehicles', 'products'));
    }

    public function update(Request $request, Quotation $quotation)
    {
        if ($quotation->status === 'converted') {
            return redirect()->route('quotations.index')->with('error', 'Converted quotations cannot be edited.');
        }

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'quotation_date' => 'required|date',
            'valid_until' => 'nullable|date',
            'status' => 'required|in:pending,accepted,rejected',
            'items' => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $totalTax = 0;

            $quotation->items()->delete(); // Remove old items

            foreach ($request->items as $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];
                $taxRate = $item['tax_rate'] ?? 0;
                $lineTax = $lineTotal * ($taxRate / 100);
                
                $totalAmount += $lineTotal;
                $totalTax += $lineTax;

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $item['product_id'] ?? null,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'tax_rate' => $item['tax_rate'] ?? 0,
                    'total' => $lineTotal,
                ]);
            }

            $netAmount = $totalAmount + $totalTax;

            $quotation->update([
                'customer_id' => $request->customer_id,
                'vehicle_id' => $request->vehicle_id,
                'quotation_date' => $request->quotation_date,
                'valid_until' => $request->valid_until,
                'total_amount' => $totalAmount,
                'tax_amount' => $totalTax,
                'net_amount' => $netAmount,
                'notes' => $request->notes,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('quotations.show', $quotation)->with('success', 'Quotation updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update quotation: ' . $e->getMessage())->withInput();
        }
    }

    public function convertToJobCard(Quotation $quotation)
    {
        if ($quotation->status === 'converted') {
            return back()->with('error', 'This quotation has already been converted to a job card.');
        }

        DB::beginTransaction();
        try {
            // Create Job Card
            $jobCard = ServiceJobCard::create([
                'garage_id' => $quotation->garage_id,
                'customer_id' => $quotation->customer_id,
                'vehicle_id' => $quotation->vehicle_id,
                'job_card_number' => 'JOB-' . strtoupper(uniqid()),
                'in_date' => now(),
                'estimated_cost' => $quotation->net_amount,
                'status' => 'pending',
                'customer_complaints' => 'Converted from Quotation ' . $quotation->quotation_number . "\n" . $quotation->notes,
            ]);

            // Create Staged Items for Job Card
            foreach ($quotation->items as $item) {
                if ($item->product_id) {
                    ServiceJobCardItem::create([
                        'service_job_card_id' => $jobCard->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'total' => $item->total,
                    ]);
                }
                // Note: If an item doesn't have a product_id (custom service), 
                // you might need to handle it differently depending on JobCard structure.
            }

            // Update Quotation Status
            $quotation->update(['status' => 'converted']);

            DB::commit();
            return redirect()->route('job-cards.edit', $jobCard)->with('success', 'Quotation successfully converted to Job Card! You can now assign a mechanic.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Conversion failed: ' . $e->getMessage());
        }
    }

    public function destroy(Quotation $quotation)
    {
        if ($quotation->status === 'converted') {
            return redirect()->route('quotations.index')->with('error', 'Cannot delete a converted quotation.');
        }
        $quotation->delete();
        return redirect()->route('quotations.index')->with('success', 'Quotation deleted successfully.');
    }
}
