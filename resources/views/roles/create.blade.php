<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        
                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Role Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required placeholder="Enter role name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mt-8">
                            <h3 class="text-lg font-bold mb-4">Permissions</h3>
                            <div class="overflow-x-auto shadow-sm border rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3">Module</th>
                                            <th class="px-6 py-3 text-center">View</th>
                                            <th class="px-6 py-3 text-center">Create</th>
                                            <th class="px-6 py-3 text-center">Update</th>
                                            <th class="px-6 py-3 text-center">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions as $module => $modulePermissions)
                                            <tr class="bg-white border-b hover:bg-gray-50">
                                                <td class="px-6 py-4 font-medium text-gray-900">
                                                    {{ ucfirst(str_replace('_', ' ', $module)) }}
                                                </td>
                                                @foreach(['view', 'create', 'edit', 'delete'] as $action)
                                                    @php
                                                        $perm = $modulePermissions->firstWhere('name', "$action $module");
                                                    @endphp
                                                    <td class="px-6 py-4 text-center">
                                                        @if($perm)
                                                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <a href="{{ route('roles.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Save Role') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
