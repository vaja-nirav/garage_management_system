<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        $returns = PurchaseReturn::with(['garage', 'purchase.supplier'])->latest()->paginate(10);
        return view('purchase-returns.index', compact('returns'));
    }

    public function create()
    {
        $purchases = Purchase::with('supplier')->latest()->get();
        return view('purchase-returns.create', compact('purchases'));
    }

    public function getPurchaseItems(Purchase $purchase)
    {
        return response()->json($purchase->items()->with('product')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'return_number' => 'required|unique:purchase_returns,return_number',
            'return_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'items' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $purchaseReturn = PurchaseReturn::create([
                'garage_id' => $request->garage_id,
                'purchase_id' => $request->purchase_id,
                'return_number' => $request->return_number,
                'return_date' => $request->return_date,
                'amount' => $request->amount,
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $itemData) {
                if (isset($itemData['quantity']) && $itemData['quantity'] > 0) {
                    $total = $itemData['quantity'] * $itemData['unit_price'];
                    
                    PurchaseReturnItem::create([
                        'purchase_return_id' => $purchaseReturn->id,
                        'product_id' => $itemData['product_id'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'total' => $total,
                    ]);

                    // Update Stock: Decrement product quantity (sending back to supplier)
                    $product = Product::find($itemData['product_id']);
                    if ($product->track_stock) {
                        $product->decrement('quantity', $itemData['quantity']);
                    }
                }
            }

            DB::commit();
            return redirect()->route('purchase-returns.index')->with('success', 'Purchase return processed successfully and stock updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(PurchaseReturn $purchaseReturn)
    {
        DB::beginTransaction();
        try {
            foreach ($purchaseReturn->items as $item) {
                $product = $item->product;
                if ($product->track_stock) {
                    $product->increment('quantity', $item->quantity);
                }
            }
            $purchaseReturn->delete();
            DB::commit();
            return redirect()->route('purchase-returns.index')->with('success', 'Return record deleted and stock reverted.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
