<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Garage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $stockStatus = $request->get('stock_status');
        $search = $request->get('search');

        $query = Product::with(['garage', 'category']);

        // Search logic
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%");
            });
        }

        // Filter logic
        if ($stockStatus === 'low_stock') {
            $query->whereColumn('quantity', '<=', 'min_stock_alert');
        } elseif ($stockStatus === 'available') {
            $query->where('quantity', '>', 0);
        }

        $products = $query->latest()->paginate($perPage)->withQueryString();
        
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $garages = Garage::all();
        $categories = ProductCategory::all();
        return view('products.create', compact('garages', 'categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']) . '-' . uniqid();
        Product::create($validated);
        return redirect()->route('products.index')->with('success', 'Product created.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $garages = Garage::all();
        $categories = ProductCategory::all();
        return view('products.edit', compact('product', 'garages', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'garage_id' => 'required|exists:garages,id',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string',
            'name' => 'required|string|max:255',
            'product_type' => 'required|string',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'min_stock_alert' => 'required|integer|min:0',
            'tax_rate' => 'required|numeric|min:0',
            'tax_type' => 'required|string|in:exclusive,inclusive',
            'hsn_code' => 'nullable|string|max:20',
            'barcode' => 'nullable|string|max:50',
            'is_service_part' => 'boolean',
            'track_stock' => 'boolean',
            'status' => 'boolean',
        ]);
        if ($request->name !== $product->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
        }
        $product->update($validated);
        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
