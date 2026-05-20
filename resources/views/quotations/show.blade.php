<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Quotation Details') }} - {{ $quotation->quotation_number }}
            </h2>
            <div class="flex space-x-2">
                @if($quotation->status !== 'converted')
                    <a href="{{ route('quotations.edit', $quotation) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Edit
                    </a>
                    
                    <form action="{{ route('quotations.convert', $quotation) }}" method="POST" onsubmit="return confirm('Convert this quotation to an active Job Card?');">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            Convert to Job Card
                        </button>
                    </form>
                @else
                    <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-md font-semibold text-xs uppercase tracking-widest">
                        Already Converted
                    </span>
                @endif
                <a href="{{ route('quotations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900" id="print-area">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Header -->
                    <div class="flex justify-between border-b pb-6 mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">QUOTATION</h1>
                            <p class="text-gray-500 mt-1">#{{ $quotation->quotation_number }}</p>
                            <p class="text-sm mt-2">
                                <span class="font-semibold">Date:</span> {{ $quotation->quotation_date->format('d M Y') }}<br>
                                <span class="font-semibold">Valid Until:</span> {{ $quotation->valid_until ? $quotation->valid_until->format('d M Y') : 'N/A' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <h2 class="text-xl font-bold text-gray-800">{{ $quotation->garage->garage_name ?? 'Garage Name' }}</h2>
                            <p class="text-sm text-gray-600">
                                {{ $quotation->garage->email ?? '' }}<br>
                                {{ $quotation->garage->phone ?? '' }}
                            </p>
                            <div class="mt-4">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    {{ $quotation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $quotation->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $quotation->status === 'converted' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $quotation->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    Status: {{ ucfirst($quotation->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer & Vehicle -->
                    <div class="flex justify-between mb-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase">Quotation For:</h3>
                            <p class="font-bold text-gray-800 text-lg">{{ $quotation->customer->first_name }} {{ $quotation->customer->last_name }}</p>
                            <p class="text-sm text-gray-600">
                                {{ $quotation->customer->phone }}<br>
                                {{ $quotation->customer->email }}
                            </p>
                        </div>
                        @if($quotation->vehicle)
                        <div class="text-right">
                            <h3 class="text-sm font-semibold text-gray-500 uppercase">Vehicle Details:</h3>
                            <p class="font-bold text-gray-800">{{ $quotation->vehicle->registration_number }}</p>
                            <p class="text-sm text-gray-600">
                                {{ $quotation->vehicle->make ?? $quotation->vehicle->brand }} {{ $quotation->vehicle->model }}<br>
                                {{ $quotation->vehicle->year }}
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Items Table -->
                    <table class="w-full text-left mb-8 border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="py-3 px-4 font-semibold text-sm text-gray-700">Description</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-700 text-right">Qty</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-700 text-right">Unit Price</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-700 text-right">Tax Rate</th>
                                <th class="py-3 px-4 font-semibold text-sm text-gray-700 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotation->items as $item)
                            <tr class="border-b border-gray-200">
                                <td class="py-3 px-4 text-sm text-gray-800">{{ $item->description }}</td>
                                <td class="py-3 px-4 text-sm text-gray-800 text-right">{{ rtrim(rtrim($item->quantity, '0'), '.') }}</td>
                                <td class="py-3 px-4 text-sm text-gray-800 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="py-3 px-4 text-sm text-gray-800 text-right">{{ rtrim(rtrim($item->tax_rate, '0'), '.') }}%</td>
                                <td class="py-3 px-4 text-sm text-gray-800 text-right">${{ number_format($item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Totals -->
                    <div class="flex justify-end mb-8">
                        <div class="w-1/2 md:w-1/3">
                            <div class="flex justify-between py-2 border-b">
                                <span class="font-semibold text-gray-600">Subtotal</span>
                                <span class="text-gray-800">${{ number_format($quotation->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b">
                                <span class="font-semibold text-gray-600">Tax Amount</span>
                                <span class="text-gray-800">${{ number_format($quotation->tax_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-3">
                                <span class="font-bold text-gray-800 text-lg">Grand Total</span>
                                <span class="font-bold text-gray-900 text-lg">${{ number_format($quotation->net_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    @if($quotation->notes)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Notes & Terms</h3>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $quotation->notes }}</p>
                    </div>
                    @endif

                </div>
                
                <div class="bg-gray-50 p-4 border-t flex justify-end">
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                        Print / Save PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #print-area, #print-area * {
                visibility: visible;
            }
            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .bg-gray-50, footer, header {
                display: none !important;
            }
        }
    </style>
</x-app-layout>
