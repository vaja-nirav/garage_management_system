<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Inspection Checklist') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-validation-errors class="mb-4" :errors="$errors" />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('inspection-checklists.store') }}" id="checklistForm">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Template Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required placeholder="e.g. 50-Point Winter Inspection" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="is_active" :value="__('Status')" />
                                <select id="is_active" name="is_active" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Description (Optional)')" />
                                <textarea id="description" name="description" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Describe the purpose of this inspection...">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <hr class="my-6">
                        <div class="flex justify-between items-end mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Checklist Items</h3>
                        </div>

                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full divide-y divide-gray-200" id="itemsTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Category (Optional)</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item/Task Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="itemsBody">
                                    <!-- Dynamic rows -->
                                </tbody>
                            </table>
                        </div>

                        <button type="button" id="addRowBtn" class="mb-6 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                            + Add Checklist Item
                        </button>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('inspection-checklists.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                            <x-primary-button>
                                {{ __('Create Template') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const itemsBody = document.getElementById('itemsBody');
                const addRowBtn = document.getElementById('addRowBtn');
                let rowCount = 0;

                function addRow() {
                    const tr = document.createElement('tr');
                    tr.className = 'item-row';
                    tr.innerHTML = `
                        <td class="px-4 py-2">
                            <input type="text" name="items[${rowCount}][category]" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm sm:text-sm" placeholder="e.g. Under Hood, Exterior">
                        </td>
                        <td class="px-4 py-2">
                            <input type="text" name="items[${rowCount}][item_name]" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm sm:text-sm" placeholder="e.g. Inspect Brake Pads" required>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button type="button" class="text-red-600 hover:text-red-900 remove-row">✕</button>
                        </td>
                    `;
                    itemsBody.appendChild(tr);
                    rowCount++;
                }

                if (addRowBtn) {
                    addRowBtn.addEventListener('click', function() {
                        addRow();
                    });
                }

                itemsBody.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-row')) {
                        if (document.querySelectorAll('.item-row').length > 1) {
                            e.target.closest('tr').remove();
                        } else {
                            alert('You must have at least one item in the checklist.');
                        }
                    }
                });

                // Add an initial row
                addRow();
            });
        </script>
    @endpush
</x-app-layout>
