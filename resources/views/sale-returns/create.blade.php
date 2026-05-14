<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Sale Return') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('sale-returns.store') }}" method="POST" id="returnForm">
                @csrf
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl mb-6 border border-slate-100">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block font-black text-xs uppercase tracking-widest text-slate-400 mb-2" for="sale_id">Select Original Invoice</label>
                                <select name="sale_id" id="sale_id" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm select2" required>
                                    <option value="">Search Invoice # or Customer...</option>
                                    @foreach($sales as $sale)
                                        <option value="{{ $sale->id }}" data-garage="{{ $sale->garage_id }}">
                                            {{ $sale->sale_number }} - {{ $sale->customer->first_name }} {{ $sale->customer->last_name }} ({{ \Carbon\Carbon::parse($sale->sale_date)->format('d M, Y') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="garage_id" id="garage_id">

                            <div>
                                <label class="block font-black text-xs uppercase tracking-widest text-slate-400 mb-2" for="return_number">Return #</label>
                                <input type="text" name="return_number" id="return_number" value="SRET-{{ strtoupper(uniqid()) }}" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm font-bold" required>
                            </div>

                            <div>
                                <label class="block font-black text-xs uppercase tracking-widest text-slate-400 mb-2" for="return_date">Return Date</label>
                                <input type="date" name="return_date" id="return_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl mb-6 border border-slate-100">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight flex items-center">
                                <span class="w-8 h-8 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                                </span>
                                Items to Credit
                            </h3>
                            <div id="loadingItems" class="hidden">
                                <span class="text-xs font-bold text-indigo-600 animate-pulse uppercase tracking-widest">Loading items...</span>
                            </div>
                        </div>

                        <div class="relative overflow-x-auto border border-slate-100 rounded-2xl overflow-hidden">
                            <table class="w-full text-sm text-left" id="returnTable">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-4 font-black">Product</th>
                                        <th class="px-6 py-4 font-black text-center">Sold Qty</th>
                                        <th class="px-6 py-4 font-black text-center">Return Qty</th>
                                        <th class="px-6 py-4 font-black text-right">Unit Price</th>
                                        <th class="px-6 py-4 font-black text-right">Credit Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">
                                            Select an invoice above to load items.
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-emerald-600 text-white font-black text-lg border-t-4 border-white">
                                    <tr>
                                        <td colspan="4" class="px-6 py-6 text-right uppercase tracking-widest">Total Credit Amount</td>
                                        <td class="px-6 py-6 text-right" id="displayGrandTotal">{{ $settings['currency_symbol'] ?? '₹' }}0.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <input type="hidden" name="amount" id="total_amount" value="0">

                        <div class="mt-8">
                            <label class="block font-black text-xs uppercase tracking-widest text-slate-400 mb-2" for="notes">Credit Reason / Notes</label>
                            <textarea name="notes" id="notes" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-sm" rows="3" placeholder="Enter reason for customer return..."></textarea>
                        </div>

                        <div class="mt-10 flex items-center justify-end border-t border-slate-50 pt-8">
                            <a href="{{ route('sale-returns.index') }}" class="text-slate-400 hover:text-slate-600 px-6 py-3 font-bold text-xs uppercase tracking-widest transition-colors">Discard</a>
                            <button type="submit" id="submitBtn" class="ml-4 inline-flex items-center px-12 py-4 bg-emerald-600 border border-transparent rounded-xl font-black text-xs text-white uppercase tracking-[0.2em] hover:bg-emerald-700 shadow-xl shadow-emerald-200 transform transition hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                Complete Sale Return
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const CURRENCY_SYMBOL = "{{ $settings['currency_symbol'] ?? '₹' }}";

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Search for options..."
            });

            $('#sale_id').on('select2:select', function (e) {
                const saleId = e.params.data.id;
                const garageId = e.params.data.element.dataset.garage;
                
                $('#garage_id').val(garageId);
                
                if (saleId) {
                    loadSaleItems(saleId);
                }
            });
        });

        function loadSaleItems(saleId) {
            $('#loadingItems').removeClass('hidden');
            $('#returnTable tbody').html('<tr><td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium animate-pulse uppercase tracking-widest">Fetching invoice items...</td></tr>');
            
            $.get(`{{ url('sale-returns/get-items') }}/${saleId}`, function(items) {
                $('#loadingItems').addClass('hidden');
                let rows = '';
                
                if (items.length === 0) {
                    rows = '<tr><td colspan="5" class="px-6 py-12 text-center text-rose-400 font-bold uppercase tracking-widest">No items found for this invoice.</td></tr>';
                    $('#submitBtn').prop('disabled', true);
                } else {
                    items.forEach(item => {
                        rows += `
                            <tr class="hover:bg-slate-50/50 transition-colors group" id="item-${item.product_id}">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-black text-slate-800">${item.product.name}</span>
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Code: ${item.product.product_code}</span>
                                    </div>
                                    <input type="hidden" name="items[${item.product_id}][product_id]" value="${item.product_id}">
                                </td>
                                <td class="px-6 py-5 text-center font-bold text-slate-500">
                                    ${item.quantity}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center">
                                        <input type="number" name="items[${item.product_id}][quantity]" value="0" min="0" max="${item.quantity}" 
                                               class="return-qty-input w-24 border-slate-200 rounded-xl text-center font-black focus:ring-emerald-500 focus:border-emerald-500 text-emerald-600" 
                                               onchange="updateRowTotal(${item.product_id})">
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right font-bold text-slate-600">
                                    <input type="hidden" name="items[${item.product_id}][unit_price]" value="${item.unit_price}">
                                    ${CURRENCY_SYMBOL}${parseFloat(item.unit_price).toFixed(2)}
                                </td>
                                <td class="px-6 py-5 text-right font-black text-slate-800 row-total">
                                    ${CURRENCY_SYMBOL}0.00
                                </td>
                            </tr>
                        `;
                    });
                    $('#submitBtn').prop('disabled', false);
                }
                
                $('#returnTable tbody').html(rows);
                calculateTotals();
            });
        }

        function updateRowTotal(productId) {
            const row = $(`#item-${productId}`);
            const qty = parseFloat(row.find('.return-qty-input').val()) || 0;
            const price = parseFloat(row.find('input[name*="unit_price"]').val()) || 0;
            const total = qty * price;
            
            row.find('.row-total').text(CURRENCY_SYMBOL + total.toFixed(2));
            calculateTotals();
        }

        function calculateTotals() {
            let total = 0;
            $('.row-total').each(function() {
                const rowVal = parseFloat($(this).text().replace(CURRENCY_SYMBOL, '')) || 0;
                total += rowVal;
            });

            $('#displayGrandTotal').text(CURRENCY_SYMBOL + total.toFixed(2));
            $('#total_amount').val(total.toFixed(2));
            
            // Disable submit if total is 0
            $('#submitBtn').prop('disabled', total <= 0);
        }
    </script>
    @endpush
</x-app-layout>
