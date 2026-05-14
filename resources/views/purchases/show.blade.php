<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Purchase Details') }}: {{ $purchase->purchase_number }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('purchases.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Back to List
                </a>
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Print Invoice
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <!-- Header Info -->
                <div class="flex justify-between mb-8 border-b pb-8">
                    <div>
                        <h3 class="text-2xl font-black text-indigo-600 mb-2">{{ $purchase->garage->garage_name }}</h3>
                        <p class="text-gray-500">{{ $purchase->garage->address }}</p>
                        <p class="text-gray-500">{{ $purchase->garage->phone }}</p>
                    </div>
                    <div class="text-right">
                        <h4 class="text-lg font-bold uppercase text-gray-400 mb-1">Supplier</h4>
                        <p class="text-xl font-bold text-gray-800">{{ $purchase->supplier->company_name }}</p>
                        <p class="text-gray-500">{{ $purchase->supplier->contact_person }}</p>
                        <p class="text-gray-500">{{ $purchase->supplier->phone }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 bg-gray-50 p-6 rounded-xl border border-gray-100">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Purchase #</span>
                        <span class="text-lg font-black text-gray-800">{{ $purchase->purchase_number }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Date</span>
                        <span class="text-lg font-black text-gray-800">{{ $purchase->purchase_date }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Status</span>
                        @if($purchase->status === 'received')
                            <span class="inline-block mt-1 px-3 py-1 text-xs font-bold bg-emerald-100 text-emerald-700 rounded-full uppercase">Received</span>
                        @else
                            <span class="inline-block mt-1 px-3 py-1 text-xs font-bold bg-blue-100 text-blue-700 rounded-full uppercase">{{ $purchase->status }}</span>
                        @endif
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Payment</span>
                        @if($purchase->payment_status === 'paid')
                            <span class="inline-block mt-1 px-3 py-1 text-xs font-bold bg-emerald-100 text-emerald-700 rounded-full uppercase">Paid</span>
                        @else
                            <span class="inline-block mt-1 px-3 py-1 text-xs font-bold bg-rose-100 text-rose-700 rounded-full uppercase">{{ $purchase->payment_status }}</span>
                        @endif
                    </div>
                </div>

                <!-- Items Table -->
                <div class="mb-8">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 border-l-4 border-indigo-600 pl-4">Purchased Items</h4>
                    <table class="w-full text-left">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 font-bold text-gray-700">Product</th>
                                <th class="px-4 py-3 font-bold text-gray-700 text-center">Quantity</th>
                                <th class="px-4 py-3 font-bold text-gray-700 text-right">Unit Price</th>
                                <th class="px-4 py-3 font-bold text-gray-700 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($purchase->items as $item)
                                <tr>
                                    <td class="px-4 py-4 font-medium text-gray-800">{{ $item->product->name }}</td>
                                    <td class="px-4 py-4 text-center">{{ (int)$item->quantity }}</td>
                                    <td class="px-4 py-4 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-4 py-4 text-right font-bold text-gray-900">${{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t-2 border-indigo-600 bg-indigo-50">
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-right font-black text-indigo-900 uppercase">Grand Total</td>
                                <td class="px-4 py-4 text-right font-black text-xl text-indigo-900 font-black">${{ number_format($purchase->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Summary -->
                <div class="flex justify-end">
                    <div class="w-1/3 space-y-3">
                        <div class="flex justify-between text-gray-600 font-medium">
                            <span>Paid Amount:</span>
                            <span class="text-emerald-600">${{ number_format($purchase->paid_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between border-t pt-3 font-black text-gray-900">
                            <span>Balance Due:</span>
                            <span class="text-rose-600">${{ number_format($purchase->total_amount - $purchase->paid_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if($purchase->notes)
                    <div class="mt-10 p-6 bg-amber-50 rounded-lg border border-amber-100">
                        <h5 class="text-sm font-bold text-amber-800 uppercase mb-2">Notes:</h5>
                        <p class="text-amber-700 italic text-sm">{{ $purchase->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
