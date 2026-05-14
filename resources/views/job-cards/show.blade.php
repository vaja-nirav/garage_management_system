<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Job Card') }}: {{ $jobCard->job_card_number }}
            </h2>
            <div class="flex space-x-2">
                <span
                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    {{ ucfirst($jobCard->status) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <style>
            .select2-container--default .select2-selection--single {
                height: 42px !important;
                padding-top: 6px !important;
                border-color: #D1D5DB !important;
            }
            .select2-container {
                width: 100% !important;
            }
        </style>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Payment & Checkout Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase">Payment Summary</h3>
                            <p class="text-3xl font-bold text-gray-900 mt-1">Total Due: ₹{{ number_format($grandTotal, 2) }}</p>
                        </div>
                        <div>
                            @if($jobCard->status !== 'delivered')
                                @if($grandTotal > 0)
                                    <button onclick="document.getElementById('checkout-modal').classList.remove('hidden')" class="bg-green-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-green-700 shadow-lg transform transition hover:scale-105">
                                        Collect Payment & Deliver
                                    </button>
                                @else
                                    <button disabled class="bg-gray-400 text-white px-8 py-3 rounded-lg font-bold cursor-not-allowed shadow-none" title="Add items to job card before collecting payment">
                                        Collect Payment & Deliver
                                    </button>
                                @endif
                            @else
                                <span class="px-6 py-2 bg-gray-100 text-gray-500 rounded-lg font-bold border border-gray-200">
                                    Vehicle Delivered & Paid
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Card Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase">Customer Information</h3>
                            <p class="mt-1 text-lg font-semibold">{{ $jobCard->customer->first_name }}
                                {{ $jobCard->customer->last_name }}</p>
                            <p class="text-sm text-gray-600">{{ $jobCard->customer->phone }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase">Vehicle Information</h3>
                            <p class="mt-1 text-lg font-semibold">{{ $jobCard->vehicle->make }}
                                {{ $jobCard->vehicle->model }}</p>
                            <p class="text-sm text-gray-600">Reg #: {{ $jobCard->vehicle->registration_number }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase">Assignment</h3>
                            <p class="mt-1 text-lg font-semibold">{{ $jobCard->staff->first_name ?? 'Not Assigned' }}
                            </p>
                            <p class="text-sm text-gray-600">In Date: {{ $jobCard->in_date }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Products / Services Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Parts & Services (Products)</h3>
                        <button onclick="document.getElementById('add-product-modal').classList.remove('hidden')"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                            + Add Part / Oil
                        </button>
                    </div>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Product / Part</th>
                                    <th scope="col" class="px-6 py-3 text-center">Quantity</th>
                                    <th scope="col" class="px-6 py-3 text-right">Unit Price</th>
                                    <th scope="col" class="px-6 py-3 text-center">Tax / GST</th>
                                    <th scope="col" class="px-6 py-3 text-right">Total</th>
                                    <th scope="col" class="px-6 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobCard->sales as $sale)
                                    @foreach ($sale->items as $item)
                                        <tr class="bg-white border-b hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <span class="font-bold text-gray-800">{{ $item->product->name }}</span>
                                                    <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-700 text-[10px] rounded-full font-bold uppercase tracking-wider">Billed</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center text-gray-600">{{ number_format($item->quantity, 2) }}</td>
                                            <td class="px-6 py-4 text-right text-gray-600">₹{{ number_format($item->unit_price, 2) }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $item->product->tax_rate }}% ({{ $item->product->tax_type }})</span>
                                            </td>
                                            <td class="px-6 py-4 text-right font-bold text-gray-900">₹{{ number_format($item->total, 2) }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="text-gray-400 cursor-not-allowed" title="Billed items cannot be removed">
                                                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach

                                <!-- Staged Items (Pending Checkout) -->
                                @foreach ($jobCard->items as $item)
                                    <tr class="bg-amber-50/20 border-b hover:bg-amber-50/40 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <span class="font-bold text-gray-800">{{ $item->product->name }}</span>
                                                <span class="ml-2 px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] rounded-full font-bold uppercase tracking-wider">Pending Sale</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center text-gray-600">{{ number_format($item->quantity, 2) }}</td>
                                        <td class="px-6 py-4 text-right text-gray-600">₹{{ number_format($item->unit_price, 2) }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $item->product->tax_rate }}% ({{ $item->product->tax_type }})</span>
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold text-amber-900">₹{{ number_format($item->total, 2) }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('job-cards.items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Remove this item from the job card?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Remove Item">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                @if ($grandTotal == 0)
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">No parts or
                                            services added yet.</td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="text-gray-500 text-xs">
                                    <td colspan="4" class="px-6 py-2 text-right uppercase tracking-widest font-bold">Subtotal:</td>
                                    <td class="px-6 py-2 text-right font-bold">₹{{ number_format($totalAmount, 2) }}</td>
                                    <td></td>
                                </tr>
                                <tr class="text-indigo-600 text-xs">
                                    <td colspan="4" class="px-6 py-2 text-right uppercase tracking-widest font-bold">Total Tax / GST:</td>
                                    <td class="px-6 py-2 text-right font-bold">₹{{ number_format($totalTax, 2) }}</td>
                                    <td></td>
                                </tr>
                                <tr class="font-black text-white bg-indigo-600 text-lg">
                                    <td colspan="4" class="px-6 py-4 text-right uppercase tracking-widest">Total Billing Amount:</td>
                                    <td class="px-6 py-4 text-right">₹{{ number_format($grandTotal, 2) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Customer Complaints & Work Done -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4 text-red-600">Customer Complaints</h3>
                        <p class="text-gray-700">
                            {{ $jobCard->customer_complaints ?? 'No complaints recorded.' }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4 text-green-600">Work Description</h3>
                        <form action="{{ route('job-cards.update', $jobCard->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <textarea name="work_done" class="w-full border-gray-300 rounded-md shadow-sm mb-4" rows="4"
                                placeholder="Enter work done details here...">{{ $jobCard->work_done }}</textarea>
                            <div class="flex justify-between items-center">
                                <select name="status" class="border-gray-300 rounded-md shadow-sm text-sm">
                                    <option value="pending" {{ $jobCard->status == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="ongoing" {{ $jobCard->status == 'ongoing' ? 'selected' : '' }}>In
                                        Progress</option>
                                    <option value="completed" {{ $jobCard->status == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="delivered" {{ $jobCard->status == 'delivered' ? 'selected' : '' }}>
                                        Delivered</option>
                                </select>
                                <button type="submit"
                                    class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700">Update
                                    Work Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Multi-item Modal for adding parts -->
    <div id="add-product-modal"
        class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-xl leading-6 font-bold text-gray-900 text-center mb-6">Add Parts & Services to Job</h3>

                <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Search & Select Product</label>
                    <div class="w-full">
                        <select id="product-search" class="select2 block w-full">
                            <option value="">Type to search product...</option>
                            @foreach (\App\Models\Product::all() as $product)
                                <option value="{{ $product->id }}" 
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->selling_price }}"
                                    data-stock="{{ $product->quantity }}"
                                    data-tax-rate="{{ $product->tax_rate }}"
                                    data-tax-type="{{ $product->tax_type }}"
                                    data-track="{{ $product->track_stock ? '1' : '0' }}">
                                    {{ $product->name }} (Stock: {{ $product->quantity }}) - ₹{{ number_format($product->selling_price, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <form action="{{ route('job-cards.addItem', $jobCard->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="garage_id" value="{{ $jobCard->garage_id }}">
                    <input type="hidden" name="customer_id" value="{{ $jobCard->customer_id }}">

                    <div class="max-h-96 overflow-y-auto mb-6">
                        <table class="w-full text-sm text-left text-gray-500" id="selected-items-table">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3">Product Name</th>
                                    <th class="px-4 py-3 w-24">Quantity</th>
                                    <th class="px-4 py-3 text-right">Price</th>
                                    <th class="px-4 py-3 text-center">Tax %</th>
                                    <th class="px-4 py-3 text-right">Total</th>
                                    <th class="px-4 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="selected-items-body">
                                <!-- Items will be added here via JS -->
                                <tr id="no-items-row">
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-400">No items selected.
                                        Use the search above to add parts.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-between items-center border-t pt-4">
                        <div class="text-lg font-bold text-gray-700">
                            Estimated Total: <span id="modal-total" class="text-indigo-600">$0.00</span>
                        </div>
                        <div class="flex space-x-3">
                            <button type="button" onclick="closeModal()"
                                class="bg-gray-200 text-gray-800 px-6 py-2 rounded-md hover:bg-gray-300 font-bold">Cancel</button>
                            <button type="submit"
                                class="bg-green-600 text-white px-8 py-2 rounded-md hover:bg-green-700 font-bold shadow-lg">Confirm
                                & Add to Job</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#product-search').select2({
                placeholder: "Search for a part...",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#add-product-modal')
            }).on('select2:select', function (e) {
                addItemToRow();
            });
        });

        function addItemToRow() {
            const select = $('#product-search');
            const productId = select.val();
            if (!productId) return;
 
            const selectedOption = select.find(':selected');
            const name = selectedOption.data('name');
            const price = parseFloat(selectedOption.data('price'));
            const stock = parseFloat(selectedOption.data('stock'));
            const taxRate = parseFloat(selectedOption.data('tax-rate')) || 0;
            const taxType = selectedOption.data('tax-type') || 'exclusive';
            const trackStock = selectedOption.data('track') == '1';
 
            // Instant Stock Check
            if (trackStock && stock <= 0) {
                toastr.error(`${name}: Out of Stock!`, "Stock Alert");
                select.val(null).trigger('change');
                return;
            }
 
            // Remove "no items" row
            $('#no-items-row').hide();
 
            // Check if already exists
            if ($(`#row-${productId}`).length) {
                alert('This item is already in the list. Please update the quantity.');
                return;
            }
 
            const row = `
                <tr id="row-${productId}" class="border-b hover:bg-gray-50">
                    <td class="px-4 py-4">
                        <input type="hidden" name="items[${productId}][id]" value="${productId}">
                        <input type="hidden" class="tax-rate" value="${taxRate}">
                        <input type="hidden" class="tax-type" value="${taxType}">
                        <div class="font-bold text-gray-800">${name}</div>
                        <div class="text-[9px] text-slate-400 uppercase font-black tracking-tighter">Tax: ${taxRate}% (${taxType})</div>
                    </td>
                    <td class="px-4 py-4">
                        <input type="number" name="items[${productId}][qty]" value="1" min="1" step="1" 
                               onchange="updateRowTotal(${productId}, ${price}, ${taxRate}, '${taxType}')" 
                               class="qty-input w-full border-gray-300 rounded-md shadow-sm">
                    </td>
                    <td class="px-4 py-4 text-right text-gray-600">₹${price.toFixed(2)}</td>
                    <td class="px-4 py-4 text-center text-slate-400 font-bold">${taxRate}%</td>
                    <td class="px-4 py-4 text-right font-black text-gray-900">₹<span class="row-total" id="total-${productId}">${price.toFixed(2)}</span></td>
                    <td class="px-4 py-4 text-center">
                        <button type="button" onclick="removeRow(${productId})" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </td>
                </tr>
            `;
 
            $('#selected-items-body').append(row);
            select.val(null).trigger('change');
            calculateGrandTotal();
        }
 
        function updateRowTotal(id, price, taxRate, taxType) {
            const qty = parseFloat($(`#row-${id} .qty-input`).val()) || 0;
            const lineTotal = qty * price;
            
            let totalToDisplay = lineTotal;
            if (taxType === 'exclusive') {
                totalToDisplay = lineTotal + (lineTotal * (taxRate / 100));
            }
 
            $(`#total-${id}`).text(totalToDisplay.toFixed(2));
            calculateGrandTotal();
        }

        function removeRow(id) {
            $(`#row-${id}`).remove();
            if ($('#selected-items-body tr').length === 1) { // only "no-items" row hidden
                $('#no-items-row').show();
            }
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let grandTotal = 0;
            $('.row-total').each(function() {
                grandTotal += parseFloat($(this).text());
            });
            $('#modal-total').text('₹' + grandTotal.toFixed(2));
        }

        function closeModal() {
            document.getElementById('add-product-modal').classList.add('hidden');
            $('#selected-items-body tr:not(#no-items-row)').remove();
            $('#no-items-row').show();
            $('#modal-total').text('$0.00');
        }
    </script>

    <!-- Checkout & Payment Modal -->
    <div id="checkout-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
                <h3 class="text-xl leading-6 font-bold text-gray-900">Collect Payment</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">You are about to finalize the payment and deliver the vehicle to the customer.</p>
                    <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                        <span class="text-gray-600 text-sm">Total Amount to Collect:</span>
                        <div class="text-2xl font-black text-green-600">₹{{ number_format($grandTotal, 2) }}</div>
                    </div>
                </div>
                
                <form action="{{ route('job-cards.checkout', $jobCard->id) }}" method="POST" class="mt-4 text-left px-7">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Payment Method</label>
                        <select name="payment_method" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="cash">Cash</option>
                            <option value="card">Debit/Credit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>

                    <div class="items-center py-3">
                        <button type="submit" class="px-4 py-3 bg-green-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300">
                            Confirm Payment & Deliver
                        </button>
                        <button type="button" onclick="document.getElementById('checkout-modal').classList.add('hidden')" class="mt-3 px-4 py-2 bg-gray-100 text-gray-700 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-200">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
