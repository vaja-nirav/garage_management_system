<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Record Expense') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('expenses.store') }}">
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

                            <!-- Expense Number -->
                            <div>
                                <x-input-label for="expense_number" :value="__('Expense Number')" />
                                <x-text-input id="expense_number" name="expense_number" type="text" class="mt-1 block w-full" value="EXP-{{ strtoupper(uniqid()) }}" required />
                            </div>

                            <!-- Category -->
                            <div>
                                <x-input-label for="expense_category" :value="__('Category')" />
                                <select id="expense_category" name="expense_category" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="rent">Rent</option>
                                    <option value="utilities">Utilities</option>
                                    <option value="salary">Salary</option>
                                    <option value="parts">Parts Purchase</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Date -->
                            <div>
                                <x-input-label for="expense_date" :value="__('Date')" />
                                <x-text-input id="expense_date" name="expense_date" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                            </div>

                            <!-- Amount -->
                            <div>
                                <x-input-label for="amount" :value="__('Amount')" />
                                <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" required />
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-primary-button>
                                {{ __('Record Expense') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
