<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Garage;
use App\Models\Product;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'garage'])->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $garages = Garage::all();
        $products = Product::where('status', 1)->get();
        return view('purchases.create', compact('suppliers', 'garages', 'products'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::create([
                'garage_id' => $request->garage_id,
                'supplier_id' => $request->supplier_id,
                'purchase_number' => $request->purchase_number,
                'purchase_date' => $request->purchase_date,
                'total_amount' => $request->total_amount,
                'paid_amount' => $request->paid_amount,
                'payment_status' => $request->payment_status,
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            if ($request->has('items')) {
                foreach ($request->items as $itemData) {
                    $product = Product::find($itemData['product_id']);
                    $quantity = $itemData['quantity'];
                    $unitPrice = $itemData['unit_price'];
                    $total = $quantity * $unitPrice;

                    PurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total' => $total,
                    ]);

                    // Increase Stock if purchase is received
                    if ($request->status === 'received' && $product->track_stock) {
                        $product->increment('quantity', $quantity);
                    }
                }
            }

            DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Purchase recorded and stock updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'garage', 'items.product']);
        return view('purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $suppliers = Supplier::all();
        $garages = Garage::all();
        $products = Product::where('status', 1)->get();
        $purchase->load('items.product');
        return view('purchases.edit', compact('purchase', 'suppliers', 'garages', 'products'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $purchase->update([
            'supplier_id' => $request->supplier_id,
            'purchase_date' => $request->purchase_date,
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'paid_amount' => $request->paid_amount,
            'notes' => $request->notes,
        ]);

        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase record deleted successfully.');
    }
}
