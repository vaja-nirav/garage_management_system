<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Appointment Details') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                    Back to List
                </a>
                <a href="{{ route('appointments.edit', $appointment->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Edit Appointment
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Customer Info -->
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Customer Information</h3>
                            <p class="text-lg font-black text-gray-900">{{ $appointment->customer->first_name }} {{ $appointment->customer->last_name }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $appointment->customer->phone }}</p>
                        </div>

                        <!-- Vehicle Info -->
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Vehicle Details</h3>
                            <p class="text-lg font-black text-gray-900">{{ $appointment->vehicle->registration_number }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $appointment->vehicle->brand }} {{ $appointment->vehicle->model }}</p>
                        </div>

                        <!-- Appointment Logistics -->
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Schedule</h3>
                            <div class="flex items-center space-x-6">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">Date</p>
                                    <p class="text-md font-bold">{{ $appointment->appointment_date }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">Time</p>
                                    <p class="text-md font-bold">{{ $appointment->appointment_time }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Location -->
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Status & Location</h3>
                            <p class="text-sm">Garage: <span class="font-bold">{{ $appointment->garage->garage_name }}</span></p>
                            <div class="mt-2">
                                <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest 
                                    {{ $appointment->status === 'scheduled' ? 'bg-indigo-100 text-indigo-600' : '' }}
                                    {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-600' : '' }}
                                    {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-600' : '' }}
                                ">
                                    {{ $appointment->status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($appointment->notes)
                    <div class="mt-8 pt-8 border-t border-gray-100">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Service Notes</h3>
                        <p class="text-gray-700 leading-relaxed bg-slate-50 p-4 rounded-lg">{{ $appointment->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
