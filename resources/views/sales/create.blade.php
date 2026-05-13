<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Sale / Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('sales.store') }}">
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

                            <!-- Sale Number -->
                            <div>
                                <x-input-label for="sale_number" :value="__('Invoice Number')" />
                                <x-text-input id="sale_number" name="sale_number" type="text" class="mt-1 block w-full" value="INV-{{ strtoupper(uniqid()) }}" required />
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

                            <!-- Sale Date -->
                            <div>
                                <x-input-label for="sale_date" :value="__('Sale Date')" />
                                <x-text-input id="sale_date" name="sale_date" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                            </div>

                            <!-- Total Amount -->
                            <div>
                                <x-input-label for="total_amount" :value="__('Total Amount')" />
                                <x-text-input id="total_amount" name="total_amount" type="number" step="0.01" class="mt-1 block w-full" value="0.00" required />
                            </div>

                             <!-- Net Amount -->
                             <div>
                                <x-input-label for="net_amount" :value="__('Net Amount (Incl. Tax)')" />
                                <x-text-input id="net_amount" name="net_amount" type="number" step="0.01" class="mt-1 block w-full" value="0.00" required />
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-primary-button>
                                {{ __('Generate Invoice') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
