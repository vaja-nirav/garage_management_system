<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleReturnController extends Controller
{
    public function index()
    {
        $returns = SaleReturn::with(['garage', 'sale.customer'])->latest()->paginate(10);
        return view('sale-returns.index', compact('returns'));
    }

    public function create()
    {
        $sales = Sale::with('customer')->latest()->get();
        return view('sale-returns.create', compact('sales'));
    }

    public function getSaleItems(Sale $sale)
    {
        return response()->json($sale->items()->with('product')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'return_number' => 'required|unique:sale_returns,return_number',
            'return_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'items' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $saleReturn = SaleReturn::create([
                'garage_id' => $request->garage_id,
                'sale_id' => $request->sale_id,
                'return_number' => $request->return_number,
                'return_date' => $request->return_date,
                'amount' => $request->amount,
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $itemData) {
                if (isset($itemData['quantity']) && $itemData['quantity'] > 0) {
                    $total = $itemData['quantity'] * $itemData['unit_price'];
                    
                    SaleReturnItem::create([
                        'sale_return_id' => $saleReturn->id,
                        'product_id' => $itemData['product_id'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'total' => $total,
                    ]);

                    // Update Stock: Increment product quantity (returning to shelf)
                    $product = Product::find($itemData['product_id']);
                    if ($product->track_stock) {
                        $product->increment('quantity', $itemData['quantity']);
                    }
                }
            }

            DB::commit();
            return redirect()->route('sale-returns.index')->with('success', 'Sale return processed successfully and stock replenished.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(SaleReturn $saleReturn)
    {
        DB::beginTransaction();
        try {
            foreach ($saleReturn->items as $item) {
                $product = $item->product;
                if ($product->track_stock) {
                    $product->decrement('quantity', $item->quantity);
                }
            }
            $saleReturn->delete();
            DB::commit();
            return redirect()->route('sale-returns.index')->with('success', 'Return record deleted and stock adjusted.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
