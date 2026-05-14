<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">SKU</p>
                            <p class="text-lg font-bold">{{ $product->sku }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Product Name</p>
                            <p class="text-lg font-bold">{{ $product->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Category</p>
                            <p class="text-lg font-bold">{{ $product->category->name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Garage</p>
                            <p class="text-lg font-bold">{{ $product->garage->garage_name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Current Stock</p>
                            <p class="text-lg font-bold text-indigo-600">{{ $product->quantity }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Min Stock Alert</p>
                            <p class="text-lg font-bold text-rose-500">{{ $product->min_stock_alert }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Purchase Price</p>
                            <p class="text-lg font-bold">{{ $settings['currency_symbol'] ?? '$' }}{{ number_format($product->purchase_price, 2) }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Selling Price</p>
                            <p class="text-lg font-bold">{{ $settings['currency_symbol'] ?? '$' }}{{ number_format($product->selling_price, 2) }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Tax Rate</p>
                            <p class="text-lg font-bold">{{ $product->tax_rate }}%</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="text-lg font-bold">
                                @if($product->status)
                                    <span class="text-green-600">Active</span>
                                @else
                                    <span class="text-red-600">Inactive</span>
                                @endif
                            </p>
                        </div>

                    </div>

                    @if($product->description)
                    <div class="mt-8 pt-6 border-t">
                        <p class="text-sm font-medium text-gray-500">Description</p>
                        <p class="mt-2 text-gray-700">{{ $product->description }}</p>
                    </div>
                    @endif

                    <div class="mt-10 flex items-center space-x-4 border-t pt-6">
                        <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Back to List</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Edit Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
