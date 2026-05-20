<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="customer_id">Select Customer</label>
                                <select name="customer_id" id="customer_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id', $appointment->customer_id) == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->first_name }} {{ $customer->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="vehicle_id">Select Vehicle</label>
                                <select name="vehicle_id" id="vehicle_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select a Vehicle</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" data-customer-id="{{ $vehicle->customer_id }}" {{ old('vehicle_id', $appointment->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->registration_number }} ({{ $vehicle->brand ?? $vehicle->make }} {{ $vehicle->model }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="garage_id">Garage</label>
                                <select name="garage_id" id="garage_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($garages as $garage)
                                        <option value="{{ $garage->id }}" {{ old('garage_id', $appointment->garage_id) == $garage->id ? 'selected' : '' }}>
                                            {{ $garage->garage_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="appointment_date">Appointment Date</label>
                                <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="appointment_time">Appointment Time</label>
                                <input type="time" name="appointment_time" id="appointment_time" value="{{ old('appointment_time', $appointment->appointment_time) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="status">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="scheduled" {{ old('status', $appointment->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block font-medium text-sm text-gray-700" for="notes">Notes</label>
                                <textarea name="notes" id="notes" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $appointment->notes) }}</textarea>
                            </div>

                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <a href="{{ route('appointments.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Update Appointment
                            </button>
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
            customerId: opt.getAttribute('data-customer-id'),
            selected: opt.selected
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
                    
                    // Maintain previous selection if valid
                    if (opt.value === currentSelectedValue || (currentSelectedValue === '' && opt.selected)) {
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
