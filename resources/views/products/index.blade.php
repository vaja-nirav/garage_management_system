<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products Inventory') }}
            </h2>
            @can('create products')
            <a href="{{ route('products.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg transform transition hover:scale-105 active:scale-95">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Product
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Bar -->
            <div
                class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 mb-6 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center space-x-2">
                    <a href="{{ route('products.index') }}"
                        class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ !request('stock_status') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">
                        All Products
                    </a>
                    <a href="{{ route('products.index', ['stock_status' => 'available']) }}"
                        class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ request('stock_status') === 'available' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">
                        Available
                    </a>
                    <a href="{{ route('products.index', ['stock_status' => 'low_stock']) }}"
                        class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ request('stock_status') === 'low_stock' ? 'bg-rose-600 text-white shadow-lg shadow-rose-100' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">
                        Low Stock
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <form action="{{ route('products.index') }}" method="GET" class="relative">
                        @if (request('stock_status'))
                            <input type="hidden" name="stock_status" value="{{ request('stock_status') }}">
                        @endif
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search SKU or Name..."
                            class="pl-10 pr-4 py-2 bg-slate-50 border-none focus:ring-2 focus:ring-indigo-500 rounded-xl text-sm w-64">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="p-0">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4 font-black">SKU / Code</th>
                                    <th class="px-6 py-4 font-black">Product Name</th>
                                    <th class="px-6 py-4 font-black">Category</th>
                                    <th class="px-6 py-4 font-black">Tax / GST</th>
                                    <th class="px-6 py-4 font-black text-right">Price</th>
                                    <th class="px-6 py-4 font-black text-center">Stock</th>
                                    <th class="px-6 py-4 font-black text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($products as $product)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <span class="font-black text-slate-800">{{ $product->sku }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-700">{{ $product->name }}</span>
                                                <span
                                                    class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $product->product_type }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest rounded-lg">
                                                {{ $product->category->name ?? 'Uncategorized' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="font-black text-slate-700 text-xs">{{ $product->tax_rate }}%</span>
                                                <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ $product->tax_type }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex flex-col items-end">
                                                <span
                                                    class="font-black text-slate-900">₹{{ number_format($product->selling_price, 2) }}</span>
                                                <span class="text-[9px] text-slate-400 font-bold">Cost:
                                                    ₹{{ number_format($product->purchase_price, 2) }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $isLowStock = $product->quantity <= $product->min_stock_alert;
                                            @endphp
                                            <div class="flex flex-col items-center">
                                                <span
                                                    class="text-lg font-black {{ $isLowStock ? 'text-rose-600' : 'text-slate-800' }}">
                                                    {{ $product->quantity }}
                                                </span>
                                                @if ($isLowStock)
                                                    <span
                                                        class="text-[9px] font-black text-rose-500 uppercase tracking-tighter">Low
                                                        Stock!</span>
                                                @else
                                                    <span
                                                        class="text-[9px] font-black text-emerald-500 uppercase tracking-tighter">In
                                                        Stock</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center space-x-2">
                                                @can('view products')
                                                <a href="{{ route('products.show', $product->id) }}"
                                                    class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                                    title="View Details">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </a>
                                                @endcan

                                                @can('edit products')
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"
                                                    title="Edit Product">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </a>
                                                @endcan

                                                @can('delete products')
                                                <form action="{{ route('products.destroy', $product->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors"
                                                        title="Delete Product">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div
                                                    class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 text-slate-300">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p
                                                    class="text-slate-500 font-medium uppercase tracking-widest text-xs">
                                                    No products found matching your criteria.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($products->hasPages())
                        <div class="p-6 border-t border-slate-50">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
