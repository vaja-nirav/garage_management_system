<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Quotation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('quotations.store') }}" id="quotationForm">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Customer -->
                            <div>
                                <x-input-label for="customer_id" :value="__('Customer')" />
                                <select id="customer_id" name="customer_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Vehicle -->
                            <div>
                                <x-input-label for="vehicle_id" :value="__('Vehicle (Optional)')" />
                                <select id="vehicle_id" name="vehicle_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select a Vehicle</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" data-customer-id="{{ $vehicle->customer_id }}">{{ $vehicle->registration_number }} ({{ $vehicle->brand ?? $vehicle->make }} {{ $vehicle->model }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date -->
                            <div>
                                <x-input-label for="quotation_date" :value="__('Quotation Date')" />
                                <x-text-input id="quotation_date" name="quotation_date" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                            </div>

                            <!-- Valid Until -->
                            <div>
                                <x-input-label for="valid_until" :value="__('Valid Until (Optional)')" />
                                <x-text-input id="valid_until" name="valid_until" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d', strtotime('+7 days')) }}" />
                            </div>
                        </div>

                        <hr class="my-6">
                        <div class="flex justify-between items-end mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Quotation Items</h3>
                        </div>

                        <div class="mb-6 bg-gray-50 p-4 rounded-md border border-gray-200">
                            <label class="block font-medium text-sm text-gray-700 mb-2" for="product_selector">Search & Add Product from Inventory</label>
                            <select id="product_selector" class="w-full select2">
                                <option value="">Search by product name...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-name="{{ $product->name }}" 
                                            data-price="{{ $product->selling_price }}" 
                                            data-tax-rate="{{ $product->tax_rate }}">
                                        {{ $product->name }} (Price: ${{ $product->selling_price }}) - Tax: {{ $product->tax_rate }}%
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full divide-y divide-gray-200" id="itemsTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description/Product</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Qty</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Unit Price</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Tax %</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Total</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="itemsBody">
                                    <!-- Dynamic rows will be added here -->
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end mb-6">
                            <div class="w-1/3 bg-gray-50 p-4 rounded-md">
                                <div class="flex justify-between mb-2">
                                    <span class="font-medium text-gray-700">Subtotal:</span>
                                    <span class="font-medium text-gray-900" id="subtotalDisplay">$0.00</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="font-medium text-gray-700">Total Tax:</span>
                                    <span class="font-medium text-gray-900" id="taxDisplay">$0.00</span>
                                </div>
                                <div class="flex justify-between border-t border-gray-300 pt-2">
                                    <span class="font-bold text-gray-900 text-lg">Grand Total:</span>
                                    <span class="font-bold text-gray-900 text-lg" id="grandTotalDisplay">$0.00</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="notes" :value="__('Notes / Terms (Optional)')" />
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ __('Create Quotation') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Vehicle Filtering
                const customerSelect = document.getElementById('customer_id');
                const vehicleSelect = document.getElementById('vehicle_id');
                const originalOptions = Array.from(vehicleSelect.options).map(opt => ({
                    value: opt.value,
                    text: opt.text,
                    customerId: opt.getAttribute('data-customer-id')
                }));

                function filterVehicles() {
                    const customerId = customerSelect.value;
                    const currentSelectedValue = vehicleSelect.value;
                    vehicleSelect.innerHTML = '';
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.text = 'Select a Vehicle';
                    vehicleSelect.appendChild(defaultOption);

                    let hasSelectedValue = false;
                    originalOptions.forEach(opt => {
                        if (opt.value === '') return;
                        if (opt.customerId == customerId) {
                            const optionEl = document.createElement('option');
                            optionEl.value = opt.value;
                            optionEl.text = opt.text;
                            optionEl.setAttribute('data-customer-id', opt.customerId);
                            if (opt.value === currentSelectedValue) {
                                optionEl.selected = true;
                                hasSelectedValue = true;
                            }
                            vehicleSelect.appendChild(optionEl);
                        }
                    });

                    if (!hasSelectedValue && vehicleSelect.options.length > 1) {
                        vehicleSelect.selectedIndex = 1;
                    }

                    if (window.jQuery && $(vehicleSelect).hasClass('select2-hidden-accessible')) {
                        $(vehicleSelect).trigger('change.select2');
                    }
                }
                
                // Initialize select2 if available
                if (window.jQuery && $.fn.select2) {
                    $('#customer_id, #vehicle_id, #product_selector').select2();
                    $('#customer_id').on('select2:select', function (e) {
                        filterVehicles();
                    });

                    // Product Selector Logic
                    $('#product_selector').on('select2:select', function (e) {
                        const data = e.params.data.element.dataset;
                        const productId = e.params.data.id;
                        
                        if (productId) {
                            const existingRow = document.querySelector(`.item-row[data-product-id="${productId}"]`);
                            if (existingRow) {
                                const qtyInput = existingRow.querySelector('.qty-input');
                                qtyInput.value = parseFloat(qtyInput.value) + 1;
                                calculateTotals();
                            } else {
                                addRow(productId, data.name, data.price, data.taxRate);
                            }
                            $(this).val('').trigger('change');
                        }
                    });
                } else {
                    customerSelect.addEventListener('change', filterVehicles);
                }
                
                filterVehicles();

                // Dynamic Line Items Calculation
                const itemsBody = document.getElementById('itemsBody');
                const addRowBtn = document.getElementById('addRowBtn');
                let rowCount = 0;

                function calculateTotals() {
                    let subtotal = 0;
                    let totalTax = 0;

                    document.querySelectorAll('.item-row').forEach(row => {
                        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                        const price = parseFloat(row.querySelector('.price-input').value) || 0;
                        const taxRate = parseFloat(row.querySelector('.tax-input').value) || 0;

                        const lineTotal = qty * price;
                        const lineTax = lineTotal * (taxRate / 100);

                        row.querySelector('.line-total').value = lineTotal.toFixed(2);

                        subtotal += lineTotal;
                        totalTax += lineTax;
                    });

                    const grandTotal = subtotal + totalTax;

                    document.getElementById('subtotalDisplay').textContent = '$' + subtotal.toFixed(2);
                    document.getElementById('taxDisplay').textContent = '$' + totalTax.toFixed(2);
                    document.getElementById('grandTotalDisplay').textContent = '$' + grandTotal.toFixed(2);
                }

                itemsBody.addEventListener('input', calculateTotals);

                function addRow(productId = '', description = '', price = '0.00', taxRate = '0') {
                    const tr = document.createElement('tr');
                    tr.className = 'item-row';
                    if (productId) tr.setAttribute('data-product-id', productId);
                    tr.innerHTML = `
                        <td class="px-4 py-2">
                            ${productId ? `<input type="hidden" name="items[${rowCount}][product_id]" value="${productId}">` : ''}
                            <input type="text" name="items[${rowCount}][description]" value="${description}" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm sm:text-sm" placeholder="Part or Custom Service Name" required>
                        </td>
                        <td class="px-4 py-2">
                            <input type="number" name="items[${rowCount}][quantity]" class="qty-input block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm sm:text-sm" value="1" min="1" step="0.01" required>
                        </td>
                        <td class="px-4 py-2">
                            <input type="number" name="items[${rowCount}][unit_price]" class="price-input block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm sm:text-sm" value="${price}" min="0" step="0.01" required>
                        </td>
                        <td class="px-4 py-2">
                            <input type="number" name="items[${rowCount}][tax_rate]" class="tax-input block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm sm:text-sm" value="${taxRate}" min="0" step="0.01">
                        </td>
                        <td class="px-4 py-2">
                            <input type="text" class="line-total block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm sm:text-sm" value="0.00" readonly>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button type="button" class="text-red-600 hover:text-red-900 remove-row">✕</button>
                        </td>
                    `;
                    itemsBody.appendChild(tr);
                    rowCount++;
                    calculateTotals();
                }

                if (addRowBtn) {
                    addRowBtn.addEventListener('click', function() {
                        addRow(); // Adds blank row
                    });
                }

                itemsBody.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-row')) {
                        e.target.closest('tr').remove();
                        calculateTotals();
                    }
                });

                calculateTotals();
            });
        </script>
    @endpush
</x-app-layout>
