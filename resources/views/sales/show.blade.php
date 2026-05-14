<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice Details') }} - {{ $sale->sale_number }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('sales.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 border border-transparent rounded-xl font-bold text-xs text-slate-600 uppercase tracking-widest hover:bg-slate-200 transition">
                    Back
                </a>
                <a href="{{ route('sales.edit', $sale->id) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-amber-600 shadow-lg transform transition hover:scale-105 active:scale-95">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Invoice
                </a>
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg transform transition hover:scale-105 active:scale-95">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 printable">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-slate-100">
                <div class="p-10">
                    <!-- Header -->
                    <div class="flex justify-between items-start border-b border-slate-100 pb-10 mb-10">
                        <div>
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="p-3 bg-indigo-600 rounded-2xl shadow-lg shadow-indigo-200">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ config('app.name', 'GaragePro') }}</h1>
                            </div>
                            <div class="text-slate-400 text-sm font-medium space-y-1">
                                <p>{{ $sale->garage->address }}</p>
                                <p>{{ $sale->garage->phone }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <h2 class="text-indigo-600 font-black text-4xl uppercase tracking-tighter mb-2">Invoice</h2>
                            <p class="text-slate-900 font-black text-lg">INV-{{ $sale->sale_number }}</p>
                            <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px] mt-2">Date: {{ \Carbon\Carbon::parse($sale->sale_date)->format('d M, Y') }}</p>
                        </div>
                    </div>

                    <!-- Client Info -->
                    <div class="grid grid-cols-2 gap-10 mb-12">
                        <div>
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Bill To</h3>
                            <div class="space-y-1">
                                <p class="text-xl font-black text-slate-900">{{ $sale->customer->first_name }} {{ $sale->customer->last_name }}</p>
                                <p class="text-slate-500 font-medium">{{ $sale->customer->phone }}</p>
                                <p class="text-slate-500 font-medium">{{ $sale->customer->email }}</p>
                            </div>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Payment Information</h3>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600 font-bold">Status:</span>
                                @if($sale->payment_status == 'paid')
                                    <span class="px-4 py-1 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-emerald-200">Paid</span>
                                @else
                                    <span class="px-4 py-1 bg-amber-500 text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-amber-200">Pending</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="relative overflow-x-auto border border-slate-100 rounded-2xl overflow-hidden mb-10">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4 font-black">Item Description</th>
                                    <th class="px-6 py-4 font-black text-center">Qty</th>
                                    <th class="px-6 py-4 font-black text-right">Unit Price</th>
                                    <th class="px-6 py-4 font-black text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($sale->items as $item)
                                <tr>
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <span class="font-black text-slate-800">{{ $item->product->name }}</span>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Part #{{ $item->product->product_code }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center font-bold text-slate-600">{{ $item->quantity }}</td>
                                    <td class="px-6 py-5 text-right font-bold text-slate-600">₹{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-6 py-5 text-right font-black text-slate-900">₹{{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div class="flex justify-end">
                        <div class="w-full md:w-1/2 space-y-3">
                            <div class="flex justify-between items-center text-slate-500 font-bold uppercase tracking-widest text-xs px-6">
                                <span>Subtotal</span>
                                <span>₹{{ number_format($sale->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-500 font-bold uppercase tracking-widest text-xs px-6">
                                <span>Tax Amount</span>
                                <span>₹{{ number_format($sale->tax_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-indigo-600 text-white rounded-2xl p-6 shadow-xl shadow-indigo-100">
                                <span class="text-lg font-black uppercase tracking-widest">Grand Total</span>
                                <span class="text-3xl font-black">₹{{ number_format($sale->net_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    @if($sale->notes)
                    <div class="mt-12 pt-10 border-t border-slate-100">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Notes</h3>
                        <p class="text-slate-600 font-medium leading-relaxed">{{ $sale->notes }}</p>
                    </div>
                    @endif

                    <div class="mt-12 text-center text-slate-300 font-bold uppercase tracking-[0.3em] text-[10px]">
                        Thank you for your business!
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .printable {
                padding: 0 !important;
            }
            .no-print, header, nav, .max-w-4xl {
                display: none !important;
            }
            .printable .max-w-4xl {
                display: block !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .bg-white {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
</x-app-layout>
