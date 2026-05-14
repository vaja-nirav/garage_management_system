<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Purchase') }}: {{ $purchase->purchase_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="garage_id">Garage</label>
                                <select name="garage_id" id="garage_id" class="mt-1 block w-full border-gray-300 bg-gray-100 rounded-md shadow-sm" readonly>
                                    <option value="{{ $purchase->garage_id }}">{{ $purchase->garage->garage_name }}</option>
                                </select>
                                <p class="text-xs text-gray-400 mt-1">Garage cannot be changed after creation.</p>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="supplier_id">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm select2" required>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="purchase_number">Purchase #</label>
                                <input type="text" value="{{ $purchase->purchase_number }}" class="mt-1 block w-full border-gray-300 bg-gray-100 rounded-md shadow-sm" readonly>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="purchase_date">Purchase Date</label>
                                <input type="date" name="purchase_date" id="purchase_date" value="{{ $purchase->purchase_date }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="status">Purchase Status</label>
                                <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="received" {{ $purchase->status == 'received' ? 'selected' : '' }}>Received</option>
                                    <option value="ordered" {{ $purchase->status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                                    <option value="pending" {{ $purchase->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="payment_status">Payment Status</label>
                                <select name="payment_status" id="payment_status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="unpaid" {{ $purchase->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="partial" {{ $purchase->payment_status == 'partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="paid" {{ $purchase->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Section (View Only in Edit for now to prevent stock logic issues) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold text-indigo-600 mb-4">Items Summary</h3>
                        
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3">Product Name</th>
                                        <th class="px-6 py-3 text-center">Qty</th>
                                        <th class="px-6 py-3 text-right">Unit Price ($)</th>
                                        <th class="px-6 py-3 text-right">Total ($)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase->items as $item)
                                        <tr class="bg-white border-b">
                                            <td class="px-6 py-4 font-medium text-gray-900">{{ $item->product->name }}</td>
                                            <td class="px-6 py-4 text-center">{{ (int)$item->quantity }}</td>
                                            <td class="px-6 py-4 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                            <td class="px-6 py-4 text-right font-bold">${{ number_format($item->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-indigo-50 font-black">
                                        <td colspan="3" class="px-6 py-4 text-right text-indigo-900">GRAND TOTAL:</td>
                                        <td class="px-6 py-4 text-right text-indigo-900 text-lg">${{ number_format($purchase->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="paid_amount">Paid Amount ($)</label>
                                <input type="number" step="0.01" name="paid_amount" id="paid_amount" value="{{ $purchase->paid_amount }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm font-bold text-emerald-600">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="notes">Notes</label>
                                <textarea name="notes" id="notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $purchase->notes }}</textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end">
                            <a href="{{ route('purchases.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
                            <button type="submit" class="ml-4 inline-flex items-center px-10 py-3 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg transform transition hover:scale-105">
                                Update Purchase Record
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    @endpush
</x-app-layout>
