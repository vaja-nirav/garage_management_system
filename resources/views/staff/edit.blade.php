<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Staff') }}: {{ $staff->first_name }} {{ $staff->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('staff.update', $staff) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="garage_id">Select Garage</label>
                                <select name="garage_id" id="garage_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($garages as $garage)
                                        <option value="{{ $garage->id }}" {{ old('garage_id', $staff->garage_id) == $garage->id ? 'selected' : '' }}>
                                            {{ $garage->garage_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('garage_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="employee_code">Employee Code</label>
                                <input type="text" name="employee_code" id="employee_code" value="{{ old('employee_code', $staff->employee_code) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @error('employee_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $staff->first_name) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $staff->last_name) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="email">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $staff->email) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $staff->phone) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="designation">Designation</label>
                                <input type="text" name="designation" id="designation" value="{{ old('designation', $staff->designation) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @error('designation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="status">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="1" {{ old('status', $staff->status) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status', $staff->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <a href="{{ route('staff.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Staff
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
