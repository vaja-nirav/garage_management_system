<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Job Card') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('job-cards.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Garage -->
                            <div>
                                <x-input-label for="garage_id" :value="__('Select Garage')" />
                                <select id="garage_id" name="garage_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach($garages as $garage)
                                        <option value="{{ $garage->id }}">{{ $garage->garage_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Job Card Number -->
                            <div>
                                <x-input-label for="job_card_number" :value="__('Job Card Number')" />
                                <x-text-input id="job_card_number" name="job_card_number" type="text" class="mt-1 block w-full" value="JOB-{{ strtoupper(uniqid()) }}" required />
                            </div>

                            <!-- Customer -->
                            <div>
                                <x-input-label for="customer_id" :value="__('Customer')" />
                                <select id="customer_id" name="customer_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Vehicle -->
                            <div>
                                <x-input-label for="vehicle_id" :value="__('Vehicle')" />
                                <select id="vehicle_id" name="vehicle_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select a Vehicle</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" data-customer-id="{{ $vehicle->customer_id }}">{{ $vehicle->registration_number }} ({{ $vehicle->make ?? $vehicle->brand }} {{ $vehicle->model }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Assigned Staff -->
                            <div>
                                <x-input-label for="staff_id" :value="__('Assign Mechanic/Staff')" />
                                <select id="staff_id" name="staff_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">{{ __('Select Mechanic') }}</option>
                                    @foreach($staff as $member)
                                        <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Estimated Cost -->
                            <div>
                                <x-input-label for="estimated_cost" :value="__('Estimated Cost')" />
                                <x-text-input id="estimated_cost" name="estimated_cost" type="number" step="0.01" class="mt-1 block w-full" value="0.00" required />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="pending">Pending</option>
                                    <option value="ongoing">Work In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>

                            <!-- Customer Complaints -->
                            <div class="md:col-span-2">
                                <x-input-label for="customer_complaints" :value="__('Customer Complaints')" />
                                <textarea id="customer_complaints" name="customer_complaints" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-primary-button>
                                {{ __('Create Job Card') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
            
            // Clear current options
            vehicleSelect.innerHTML = '';
            
            // Add default empty option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.text = 'Select a Vehicle';
            vehicleSelect.appendChild(defaultOption);

            let hasSelectedValue = false;

            originalOptions.forEach(opt => {
                if (opt.value === '') return; // Skip original empty option
                
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
                vehicleSelect.selectedIndex = 1; // Select first valid vehicle
            }
        }

        if (customerSelect) {
            customerSelect.addEventListener('change', filterVehicles);
            filterVehicles(); // Initial filter on load
        }
    });
</script>
