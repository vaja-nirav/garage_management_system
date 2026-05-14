<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                            <div class="mt-4 space-y-2">
                                <p><strong>Name:</strong> {{ $customer->first_name }} {{ $customer->last_name }}</p>
                                <p><strong>Email:</strong> {{ $customer->email }}</p>
                                <p><strong>Phone:</strong> {{ $customer->phone }}</p>
                                <p><strong>Gender:</strong> {{ ucfirst($customer->gender) }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Account Information</h3>
                            <div class="mt-4 space-y-2">
                                <p><strong>Customer Code:</strong> {{ $customer->customer_code }}</p>
                                <p><strong>Garage:</strong> {{ $customer->garage->garage_name }}</p>
                                <p><strong>Status:</strong> {{ $customer->status ? 'Active' : 'Inactive' }}</p>
                                <p><strong>Customer Type:</strong> {{ ucfirst($customer->customer_type) }}</p>
                                <p><strong>Membership:</strong> {{ $customer->membership_status ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900">Address</h3>
                            <p class="mt-4">{{ $customer->address }}, {{ $customer->city }}, {{ $customer->state }}, {{ $customer->country }} - {{ $customer->zip_code }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end">
                        <a href="{{ route('customers.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Back to List</a>
                        <a href="{{ route('customers.edit', $customer->id) }}" class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit Customer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
