<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Service Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('appointments.store') }}">
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
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->registration_number }} ({{ $vehicle->make }} {{ $vehicle->model }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date -->
                            <div>
                                <x-input-label for="appointment_date" :value="__('Appointment Date')" />
                                <x-text-input id="appointment_date" name="appointment_date" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                            </div>

                            <!-- Time -->
                            <div>
                                <x-input-label for="appointment_time" :value="__('Appointment Time')" />
                                <x-text-input id="appointment_time" name="appointment_time" type="time" class="mt-1 block w-full" required />
                            </div>

                            <!-- Service Type -->
                            <div>
                                <x-input-label for="service_type" :value="__('Service Type')" />
                                <select id="service_type" name="service_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="routine">Routine Service</option>
                                    <option value="repair">Major Repair</option>
                                    <option value="bodywork">Body Work</option>
                                    <option value="electrical">Electrical</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-primary-button>
                                {{ __('Confirm Appointment') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
