<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="garage_id">Select Garage</label>
                                <select name="garage_id" id="garage_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($garages as $garage)
                                        <option value="{{ $garage->id }}" {{ old('garage_id') == $garage->id ? 'selected' : '' }}>
                                            {{ $garage->garage_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="product_category_id">Select Category</label>
                                <select name="product_category_id" id="product_category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">-- No Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="sku">SKU</label>
                                <input type="text" name="sku" id="sku" value="{{ old('sku', 'PRD-' . strtoupper(uniqid())) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="name">Product Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="product_type">Product Type</label>
                                <select name="product_type" id="product_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="standard" {{ old('product_type') == 'standard' ? 'selected' : '' }}>Standard</option>
                                    <option value="service" {{ old('product_type') == 'service' ? 'selected' : '' }}>Service</option>
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="quantity">Initial Quantity</label>
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 0) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="purchase_price">Purchase Price ($)</label>
                                <input type="number" step="0.01" name="purchase_price" id="purchase_price" value="{{ old('purchase_price', 0) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="selling_price">Selling Price ($)</label>
                                <input type="number" step="0.01" name="selling_price" id="selling_price" value="{{ old('selling_price', 0) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="min_stock_alert">Min Stock Alert</label>
                                <input type="number" name="min_stock_alert" id="min_stock_alert" value="{{ old('min_stock_alert', 5) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>
                            
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="tax_rate">Tax Rate (%)</label>
                                <input type="number" step="0.01" name="tax_rate" id="tax_rate" value="{{ old('tax_rate', 0) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="tax_type">Tax Type</label>
                                <select name="tax_type" id="tax_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="exclusive" {{ old('tax_type') == 'exclusive' ? 'selected' : '' }}>Exclusive (GST Extra)</option>
                                    <option value="inclusive" {{ old('tax_type') == 'inclusive' ? 'selected' : '' }}>Inclusive (GST included in price)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="hsn_code">HSN/SAC Code</label>
                                <input type="text" name="hsn_code" id="hsn_code" value="{{ old('hsn_code') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="barcode">Barcode</label>
                                <input type="text" name="barcode" id="barcode" value="{{ old('barcode') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="status">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <!-- Hidden values for boolean defaults to simplify form -->
                            <input type="hidden" name="is_service_part" value="0">
                            <input type="hidden" name="track_stock" value="1">

                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Save Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
