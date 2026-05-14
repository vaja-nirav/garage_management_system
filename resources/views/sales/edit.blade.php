<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Sale / Invoice') }} - {{ $sale->sale_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('sales.update', $sale->id) }}" method="POST" id="saleForm">
                @csrf
                @method('PUT')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl mb-6 border border-slate-100">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block font-black text-xs uppercase tracking-widest text-slate-400 mb-2" for="garage_id">Garage</label>
                                <select name="garage_id" id="garage_id" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" required>
                                    @foreach($garages as $garage)
                                        <option value="{{ $garage->id }}" {{ $sale->garage_id == $garage->id ? 'selected' : '' }}>{{ $garage->garage_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-black text-xs uppercase tracking-widest text-slate-400 mb-2" for="customer_id">Customer</label>
                                <select name="customer_id" id="customer_id" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm select2" required>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->phone }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-black text-xs uppercase tracking-widest text-slate-400 mb-2" for="sale_number">Invoice #</label>
                                <input type="text" name="sale_number" id="sale_number" value="{{ $sale->sale_number }}" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm font-bold" required>
                            </div>

                            <div>
                                <label class="block font-black text-xs uppercase tracking-widest text-slate-400 mb-2" for="sale_date">Sale Date</label>
                                <input type="date" name="sale_date" id="sale_date" value="{{ $sale->sale_date }}" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl mb-6 border border-slate-100">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight mb-6 flex items-center">
                            <span class="w-8 h-8 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </span>
                            Update Products / Services
                        </h3>
                        <div class="mb-8">
                            <select id="product_selector" class="w-full select2">
                                <option value="">Search to add more products...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-name="{{ $product->name }}" 
                                            data-price="{{ $product->selling_price }}" 
                                            data-stock="{{ $product->quantity }}">
                                        {{ $product->name }} (Price: {{ $settings['currency_symbol'] ?? '₹' }}{{ $product->selling_price }}) - Stock: {{ $product->quantity }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="relative overflow-x-auto border border-slate-100 rounded-2xl overflow-hidden">
                            <table class="w-full text-sm text-left" id="itemsTable">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-4 font-black">Product</th>
                                        <th class="px-6 py-4 font-black text-center">Quantity</th>
                                        <th class="px-6 py-4 font-black text-right">Price</th>
                                        <th class="px-6 py-4 font-black text-right">Subtotal</th>
                                        <th class="px-6 py-4 font-black text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($sale->items as $item)
                                    <tr class="bg-white hover:bg-slate-50 transition-colors group" id="item-{{ $item->product_id }}">
                                        <td class="px-6 py-5">
                                            <div class="flex flex-col">
                                                <span class="font-black text-slate-800">{{ $item->product->name }}</span>
                                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Part #{{ $item->product->product_code }}</span>
                                            </div>
                                            <input type="hidden" name="items[{{ $item->product_id }}][product_id]" value="{{ $item->product_id }}">
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <input type="number" name="items[{{ $item->product_id }}][quantity]" value="{{ $item->quantity }}" min="1" 
                                                   class="qty-input w-24 border-slate-200 rounded-xl text-center font-black focus:ring-indigo-500 focus:border-indigo-500 text-indigo-600" 
                                                   onchange="updateRowTotal({{ $item->product_id }})">
                                        </td>
                                        <td class="px-6 py-5 text-right font-bold text-slate-600">
                                            <input type="number" step="0.01" name="items[{{ $item->product_id }}][unit_price]" value="{{ $item->unit_price }}" 
                                                   class="price-input w-28 border-slate-200 rounded-xl text-right font-bold focus:ring-indigo-500 focus:border-indigo-500" 
                                                   onchange="updateRowTotal({{ $item->product_id }})">
                                        </td>
                                        <td class="px-6 py-5 text-right font-black text-slate-800 row-total">{{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($item->total, 2) }}</td>
                                        <td class="px-6 py-5 text-center">
                                            <button type="button" onclick="removeRow({{ $item->product_id }})" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors">
                                                <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-slate-50 font-bold text-gray-900 border-t-2 border-indigo-600">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right uppercase tracking-widest text-xs text-slate-400">Total Amount</td>
                                        <td class="px-6 py-4 text-right font-black" id="displayTotal">{{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($sale->total_amount, 2) }}</td>
                                        <td></td>
                                    </tr>
                                    <tr class="text-indigo-600 bg-indigo-50/30">
                                        <td colspan="3" class="px-6 py-4 text-right uppercase tracking-widest text-xs">Tax ({{ $settings['default_tax'] ?? 0 }}%)</td>
                                        <td class="px-6 py-4 text-right font-black" id="displayTax">{{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($sale->tax_amount, 2) }}</td>
                                        <td></td>
                                    </tr>
                                    <tr class="bg-indigo-600 text-white text-lg">
                                        <td colspan="3" class="px-6 py-6 text-right uppercase tracking-[0.2em] font-black">Grand Total</td>
                                        <td class="px-6 py-6 text-right font-black" id="displayGrandTotal">{{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($sale->net_amount, 2) }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <input type="hidden" name="total_amount" id="total_amount" value="{{ $sale->total_amount }}">
                        <input type="hidden" name="tax_amount" id="tax_amount" value="{{ $sale->tax_amount }}">
                        <input type="hidden" name="net_amount" id="net_amount" value="{{ $sale->net_amount }}">

                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-black text-xs uppercase tracking-widest text-slate-400 mb-2" for="notes">Notes / Special Instructions</label>
                                <textarea name="notes" id="notes" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-sm" rows="3">{{ $sale->notes }}</textarea>
                            </div>
                        </div>

                        <div class="mt-10 flex items-center justify-end border-t border-slate-50 pt-8">
                            <a href="{{ route('sales.index') }}" class="text-slate-400 hover:text-slate-600 px-6 py-3 font-bold text-xs uppercase tracking-widest transition-colors">Cancel Edits</a>
                            <button type="submit" class="ml-4 inline-flex items-center px-12 py-4 bg-indigo-600 border border-transparent rounded-xl font-black text-xs text-white uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-xl shadow-indigo-200 transform transition hover:scale-105 active:scale-95">
                                Update Invoice & Sync Stock
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const DEFAULT_TAX_RATE = {{ $settings['default_tax'] ?? 0 }};
        const CURRENCY_SYMBOL = "{{ $settings['currency_symbol'] ?? '₹' }}";

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Search for options..."
            });

            $('#product_selector').on('select2:select', function (e) {
                const data = e.params.data.element.dataset;
                const productId = e.params.data.id;
                
                if (productId) {
                    addProductToTable(productId, data.name, data.price);
                    $(this).val('').trigger('change');
                }
            });
        });

        function addProductToTable(id, name, price) {
            if ($(`#item-${id}`).length > 0) {
                let qtyInput = $(`#item-${id} .qty-input`);
                qtyInput.val(parseInt(qtyInput.val()) + 1);
                updateRowTotal(id);
                return;
            }

            const row = `
                <tr class="bg-white border-b hover:bg-slate-50 transition-colors" id="item-${id}">
                    <td class="px-6 py-5">
                        <span class="font-black text-slate-800">${name}</span>
                        <input type="hidden" name="items[${id}][product_id]" value="${id}">
                    </td>
                    <td class="px-6 py-5 text-center">
                        <input type="number" name="items[${id}][quantity]" value="1" min="1" 
                               class="qty-input w-24 border-slate-200 rounded-xl text-center font-black focus:ring-indigo-500 focus:border-indigo-500 text-indigo-600" 
                               onchange="updateRowTotal(${id})">
                    </td>
                    <td class="px-6 py-5 text-right font-bold text-slate-600">
                        <input type="number" step="0.01" name="items[${id}][unit_price]" value="${price}" 
                               class="price-input w-28 border-slate-200 rounded-xl text-right font-bold focus:ring-indigo-500 focus:border-indigo-500" 
                               onchange="updateRowTotal(${id})">
                    </td>
                    <td class="px-6 py-5 text-right font-black text-slate-800 row-total">${CURRENCY_SYMBOL}${parseFloat(price).toFixed(2)}</td>
                    <td class="px-6 py-5 text-center">
                        <button type="button" onclick="removeRow(${id})" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                </tr>
            `;

            $('#itemsTable tbody').append(row);
            calculateTotals();
        }

        function updateRowTotal(id) {
            const qty = $(`#item-${id} .qty-input`).val() || 0;
            const price = $(`#item-${id} .price-input`).val() || 0;
            const total = qty * price;
            $(`#item-${id} .row-total`).text(CURRENCY_SYMBOL + total.toFixed(2));
            calculateTotals();
        }

        function removeRow(id) {
            $(`#item-${id}`).remove();
            calculateTotals();
        }

        function calculateTotals() {
            let total = 0;
            $('.row-total').each(function() {
                const rowVal = parseFloat($(this).text().replace(CURRENCY_SYMBOL, '')) || 0;
                total += rowVal;
            });

            const tax = total * (DEFAULT_TAX_RATE / 100);
            const grandTotal = total + tax;

            $('#displayTotal').text(CURRENCY_SYMBOL + total.toFixed(2));
            $('#displayTax').text(CURRENCY_SYMBOL + tax.toFixed(2));
            $('#displayGrandTotal').text(CURRENCY_SYMBOL + grandTotal.toFixed(2));

            $('#total_amount').val(total.toFixed(2));
            $('#tax_amount').val(tax.toFixed(2));
            $('#net_amount').val(grandTotal.toFixed(2));
        }
    </script>
    @endpush
</x-app-layout>
