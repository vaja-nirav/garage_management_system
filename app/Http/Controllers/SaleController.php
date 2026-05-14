<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Garage;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $products = Product::where('status', 1)->get();
        return view('sales.create', compact('customers', 'garages', 'products'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'garage_id' => $request->garage_id,
                'customer_id' => $request->customer_id,
                'service_job_card_id' => $request->service_job_card_id,
                'sale_number' => $request->sale_number,
                'sale_date' => $request->sale_date,
                'payment_status' => 'pending',
                'notes' => $request->notes,
            ]);

            $totalAmount = 0;

            if ($request->has('items')) {
                foreach ($request->items as $itemData) {
                    $product = Product::find($itemData['product_id']);
                    $quantity = $itemData['quantity'] ?? 1;
                    $unitPrice = $itemData['unit_price'] ?? $product->selling_price;
                    $rowTotal = $unitPrice * $quantity;

                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total' => $rowTotal,
                    ]);

                    // Deduct Stock if tracking is enabled
                    if ($product->track_stock) {
                        $product->decrement('quantity', $quantity);
                    }

                    $totalAmount += $rowTotal;
                }
            }

            // Calculate Tax from request (sent from JS)
            $taxAmount = $request->tax_amount ?? 0;
            $netAmount = $totalAmount + $taxAmount;

            $sale->update([
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'net_amount' => $netAmount,
            ]);

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Sale created successfully with automatic tax calculation.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['customer', 'garage', 'items.product']);
        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        DB::beginTransaction();
        try {
            // Revert Stock
            foreach ($sale->items as $item) {
                $product = $item->product;
                if ($product && $product->track_stock) {
                    $product->increment('quantity', $item->quantity);
                }
            }
            $sale->delete();
            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sale deleted and stock reverted.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit(Sale $sale)
    {
        $sale->load('items.product');
        $customers = Customer::all();
        $garages = Garage::all();
        $products = Product::where('status', 1)->get();
        return view('sales.edit', compact('sale', 'customers', 'garages', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        DB::beginTransaction();
        try {
            // 1. Revert Old Stock
            foreach ($sale->items as $item) {
                $product = $item->product;
                if ($product && $product->track_stock) {
                    $product->increment('quantity', $item->quantity);
                }
            }

            // 2. Delete Old Items
            $sale->items()->delete();

            // 3. Update Sale Header
            $sale->update([
                'garage_id' => $request->garage_id,
                'customer_id' => $request->customer_id,
                'sale_number' => $request->sale_number,
                'sale_date' => $request->sale_date,
                'notes' => $request->notes,
            ]);

            $totalAmount = 0;

            // 4. Create New Items & Apply New Stock
            if ($request->has('items')) {
                foreach ($request->items as $itemData) {
                    $product = Product::find($itemData['product_id']);
                    $quantity = $itemData['quantity'] ?? 1;
                    $unitPrice = $itemData['unit_price'] ?? $product->selling_price;
                    $rowTotal = $unitPrice * $quantity;

                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total' => $rowTotal,
                    ]);

                    if ($product->track_stock) {
                        $product->decrement('quantity', $quantity);
                    }

                    $totalAmount += $rowTotal;
                }
            }

            // 5. Update Totals
            $taxAmount = $request->tax_amount ?? 0;
            $netAmount = $totalAmount + $taxAmount;

            $sale->update([
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'net_amount' => $netAmount,
            ]);

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sale updated and stock adjusted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Update failed: ' . $e->getMessage())->withInput();
        }
    }
}
