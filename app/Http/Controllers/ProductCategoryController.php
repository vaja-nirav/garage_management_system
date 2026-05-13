<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Garage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::with('garage')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $garages = Garage::all();
        return view('categories.create', compact('garages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'garage_id' => 'required|exists:garages,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);
        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
        ProductCategory::create($validated);
        return redirect()->route('categories.index')->with('success', 'Category created.');
    }

    public function show(ProductCategory $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit(ProductCategory $category)
    {
        $garages = Garage::all();
        return view('categories.edit', compact('category', 'garages'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        $validated = $request->validate([
            'garage_id' => 'required|exists:garages,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);
        if ($request->name !== $category->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
        }
        $category->update($validated);
        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(ProductCategory $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }
}
