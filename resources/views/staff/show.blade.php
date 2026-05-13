<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Staff Details') }}: {{ $staff->first_name }} {{ $staff->last_name }}
            </h2>
            <a href="{{ route('staff.edit', $staff) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                Edit Staff
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Employee Code</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $staff->employee_code }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Designation</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $staff->designation }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Email</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $staff->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Phone</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $staff->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Garage</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $staff->garage->garage_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Status</p>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $staff->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $staff->status ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
