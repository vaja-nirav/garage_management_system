<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Purchase') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('purchases.store') }}" method="POST">
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
                                <label class="block font-medium text-sm text-gray-700" for="supplier_id">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm select2" required>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="purchase_number">Purchase #</label>
                                <input type="text" name="purchase_number" id="purchase_number" value="{{ 'PUR-' . strtoupper(uniqid()) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="purchase_date">Purchase Date</label>
                                <input type="date" name="purchase_date" id="purchase_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="status">Purchase Status</label>
                                <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="received">Received (Increases Stock)</option>
                                    <option value="ordered">Ordered (Pending)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="payment_status">Payment Status</label>
                                <select name="payment_status" id="payment_status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="unpaid">Unpaid</option>
                                    <option value="partial">Partial</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-indigo-600">Purchase Items</h3>
                            <div class="w-1/3">
                                <select id="product-selector" class="w-full border-gray-300 rounded-md shadow-sm select2">
                                    <option value="">-- Search & Add Product --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" 
                                                data-price="{{ $product->purchase_price }}" 
                                                data-name="{{ $product->name }}"
                                                data-stock="{{ $product->quantity }}">
                                            {{ $product->name }} (Stock: {{ (int)$product->quantity }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500" id="items-table">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3">Product Name</th>
                                        <th class="px-6 py-3 text-center">Current Stock</th>
                                        <th class="px-6 py-3">Qty</th>
                                        <th class="px-6 py-3">Unit Price ($)</th>
                                        <th class="px-6 py-3">Total ($)</th>
                                        <th class="px-6 py-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="items-body">
                                    <tr id="no-items-row">
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">No products added yet. Use the search above.</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray-50 font-bold">
                                        <td colspan="3" class="px-6 py-4 text-right">Grand Total:</td>
                                        <td class="px-6 py-4" id="grand-total-display">$0.00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <input type="hidden" name="total_amount" id="total_amount_input" value="0">
                        
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="paid_amount">Paid Amount ($)</label>
                                <input type="number" step="0.01" name="paid_amount" id="paid_amount" value="0" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm font-bold text-emerald-600">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="notes">Notes</label>
                                <textarea name="notes" id="notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end">
                            <a href="{{ route('purchases.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
                            <button type="submit" class="ml-4 inline-flex items-center px-10 py-3 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg transform transition hover:scale-105">
                                Finalize Purchase
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

            $('#product-selector').on('select2:select', function (e) {
                const data = e.params.data;
                const option = $(this).find(`option[value="${data.id}"]`);
                const name = option.data('name');
                const price = option.data('price');
                const stock = option.data('stock');

                if (data.id) {
                    window.addProductToTable(data.id, name, price, stock);
                    $(this).val(null).trigger('change');
                }
            });
        });

        function addProductToTable(id, name, price, stock) {
            $('#no-items-row').hide();
            
            // Check if already exists
            if ($(`#row-${id}`).length) {
                let qtyInput = $(`#qty-${id}`);
                qtyInput.val(parseInt(qtyInput.val()) + 1);
                updateRowTotal(id);
                return;
            }

            const row = `
                <tr id="row-${id}" class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">
                        ${name}
                        <input type="hidden" name="items[${id}][product_id]" value="${id}">
                    </td>
                    <td class="px-6 py-4 text-center font-bold text-blue-600">
                        ${stock}
                    </td>
                    <td class="px-6 py-4">
                        <input type="number" name="items[${id}][quantity]" id="qty-${id}" value="1" min="1" 
                            class="w-20 border-gray-300 rounded-md shadow-sm py-1" oninput="updateRowTotal(${id})">
                    </td>
                    <td class="px-6 py-4">
                        <input type="number" step="0.01" name="items[${id}][unit_price]" id="price-${id}" value="${price}" 
                            class="w-24 border-gray-300 rounded-md shadow-sm py-1" oninput="updateRowTotal(${id})">
                    </td>
                    <td class="px-6 py-4 font-bold">$<span id="total-${id}" class="row-total">${price}</span></td>
                    <td class="px-6 py-4 text-red-600 cursor-pointer font-bold" onclick="removeRow(${id})">Remove</td>
                </tr>
            `;
            $('#items-body').append(row);
            calculateGrandTotal();
        }

        window.addProductToTable = addProductToTable;


        function updateRowTotal(id) {
            const qty = parseFloat($(`#qty-${id}`).val()) || 0;
            const price = parseFloat($(`#price-${id}`).val()) || 0;
            const total = qty * price;
            $(`#total-${id}`).text(total.toFixed(2));
            calculateGrandTotal();
        }

        function removeRow(id) {
            $(`#row-${id}`).remove();
            if ($('#items-body tr').length === 1) {
                $('#no-items-row').show();
            }
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let grandTotal = 0;
            $('.row-total').each(function() {
                grandTotal += parseFloat($(this).text());
            });
            $('#grand-total-display').text('$' + grandTotal.toFixed(2));
            $('#total_amount_input').val(grandTotal.toFixed(2));
        }
    </script>
    @endpush
</x-app-layout>
