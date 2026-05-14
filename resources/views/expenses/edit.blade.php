<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Expense') }}: {{ $expense->expense_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Garage -->
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="garage_id">Garage</label>
                                <select name="garage_id" id="garage_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($garages as $garage)
                                        <option value="{{ $garage->id }}" {{ $expense->garage_id == $garage->id ? 'selected' : '' }}>
                                            {{ $garage->garage_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Expense Number (Read-only) -->
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="expense_number">Expense #</label>
                                <input type="text" name="expense_number" value="{{ $expense->expense_number }}" class="mt-1 block w-full border-gray-300 bg-gray-100 rounded-md shadow-sm" readonly>
                            </div>

                            <!-- Expense Category -->
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="expense_category">Category</label>
                                <select id="expense_category" name="expense_category" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="rent" {{ $expense->expense_category == 'rent' ? 'selected' : '' }}>Rent</option>
                                    <option value="utilities" {{ $expense->expense_category == 'utilities' ? 'selected' : '' }}>Utilities</option>
                                    <option value="salary" {{ $expense->expense_category == 'salary' ? 'selected' : '' }}>Salary</option>
                                    <option value="parts" {{ $expense->expense_category == 'parts' ? 'selected' : '' }}>Parts Purchase</option>
                                    <option value="other" {{ $expense->expense_category == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <!-- Expense Date -->
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="expense_date">Date</label>
                                <input type="date" name="expense_date" id="expense_date" value="{{ $expense->expense_date }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>

                            <!-- Amount -->
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="amount">Amount (₹)</label>
                                <input type="number" step="0.01" name="amount" id="amount" value="{{ $expense->amount }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm font-bold text-rose-600" required>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <label class="block font-medium text-sm text-gray-700" for="notes">Description / Notes</label>
                            <textarea name="notes" id="notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ $expense->notes }}</textarea>
                        </div>

                        <div class="mt-8 flex items-center justify-end">
                            <a href="{{ route('expenses.update', $expense->id) }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
                            <button type="submit" class="ml-4 inline-flex items-center px-10 py-3 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg transform transition hover:scale-105">
                                Update Expense
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
