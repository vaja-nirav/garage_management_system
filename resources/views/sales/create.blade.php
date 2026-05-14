<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Sale / Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                @csrf
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="garage_id">Garage</label>
                                <select name="garage_id" id="garage_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($garages as $garage)
                                        <option value="{{ $garage->id }}">{{ $garage->garage_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="customer_id">Customer</label>
                                <select name="customer_id" id="customer_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm select2" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->phone }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="sale_number">Invoice #</label>
                                <input type="text" name="sale_number" id="sale_number" value="INV-{{ strtoupper(uniqid()) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="sale_date">Sale Date</label>
                                <input type="date" name="sale_date" id="sale_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold text-indigo-600 mb-4">Add Products / Services</h3>
                        <div class="mb-6">
                            <select id="product_selector" class="w-full select2">
                                <option value="">Search by product name or code...</option>
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

                        <div class="relative overflow-x-auto border rounded-xl overflow-hidden">
                            <table class="w-full text-sm text-left" id="itemsTable">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-6 py-3">Product</th>
                                        <th class="px-6 py-3 text-center">Quantity</th>
                                        <th class="px-6 py-3 text-right">Price</th>
                                        <th class="px-6 py-3 text-right">Subtotal</th>
                                        <th class="px-6 py-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    <!-- Dynamic Items -->
                                </tbody>
                                <tfoot class="bg-slate-50 font-bold text-gray-900 border-t-2 border-indigo-600">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right uppercase">Total Amount</td>
                                        <td class="px-6 py-4 text-right" id="displayTotal">{{ $settings['currency_symbol'] ?? '₹' }}0.00</td>
                                        <td></td>
                                    </tr>
                                    <tr class="text-indigo-600">
                                        <td colspan="3" class="px-6 py-4 text-right uppercase">Tax ({{ $settings['default_tax'] ?? 0 }}%)</td>
                                        <td class="px-6 py-4 text-right" id="displayTax">{{ $settings['currency_symbol'] ?? '₹' }}0.00</td>
                                        <td></td>
                                    </tr>
                                    <tr class="bg-indigo-500 text-white text-lg">
                                        <td colspan="3" class="px-6 py-4 text-right uppercase font-black">Grand Total</td>
                                        <td class="px-6 py-4 text-right font-black" id="displayGrandTotal">{{ $settings['currency_symbol'] ?? '₹' }}0.00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <input type="hidden" name="total_amount" id="total_amount" value="0">
                        <input type="hidden" name="tax_amount" id="tax_amount" value="0">
                        <input type="hidden" name="net_amount" id="net_amount" value="0">

                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="notes">Notes / Special Instructions</label>
                                <textarea name="notes" id="notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Any additional notes for the customer..."></textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end border-t pt-8">
                            <a href="{{ route('sales.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2 font-medium">Discard Invoice</a>
                            <button type="submit" class="ml-4 inline-flex items-center px-10 py-3 bg-indigo-600 border border-transparent rounded-lg font-black text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-xl transform transition hover:scale-105 active:scale-95">
                                Generate Professional Invoice
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
            // Check if product already exists
            if ($(`#item-${id}`).length > 0) {
                let qtyInput = $(`#item-${id} .qty-input`);
                qtyInput.val(parseInt(qtyInput.val()) + 1);
                updateRowTotal(id);
                return;
            }

            const row = `
                <tr class="bg-white border-b hover:bg-slate-50 transition-colors" id="item-${id}">
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-900">${name}</span>
                        <input type="hidden" name="items[${id}][product_id]" value="${id}">
                    </td>
                    <td class="px-6 py-4 text-center">
                        <input type="number" name="items[${id}][quantity]" value="1" min="1" 
                               class="qty-input w-20 border-gray-300 rounded-md text-center focus:ring-indigo-500" 
                               onchange="updateRowTotal(${id})">
                    </td>
                    <td class="px-6 py-4 text-right font-medium">
                        <input type="number" step="0.01" name="items[${id}][unit_price]" value="${price}" 
                               class="price-input w-24 border-gray-300 rounded-md text-right focus:ring-indigo-500" 
                               onchange="updateRowTotal(${id})">
                    </td>
                    <td class="px-6 py-4 text-right font-black text-slate-800 row-total">${CURRENCY_SYMBOL}${parseFloat(price).toFixed(2)}</td>
                    <td class="px-6 py-4 text-center">
                        <button type="button" onclick="removeRow(${id})" class="text-rose-500 hover:text-rose-700 transition-colors">
                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                </tr>
            `;

            $('#itemsTable tbody').append(row);
            calculateTotals();
        }

        function updateRowTotal(id) {
            const qty = $(`#item-${id} .qty-input`).val();
            const price = $(`#item-${id} .price-input`).val();
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
                const rowVal = parseFloat($(this).text().replace(CURRENCY_SYMBOL, ''));
                total += isNaN(rowVal) ? 0 : rowVal;
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
