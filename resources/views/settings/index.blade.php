<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('System Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <div>
                                <x-input-label for="app_name" :value="__('Application Name')" />
                                <x-text-input id="app_name" name="app_name" type="text" class="mt-1 block w-full" value="{{ $settings['app_name'] ?? 'Garage SaaS' }}" />
                            </div>

                            <div>
                                <x-input-label for="default_tax" :value="__('Default Tax (%)')" />
                                <x-text-input id="default_tax" name="default_tax" type="text" class="mt-1 block w-full" value="{{ $settings['default_tax'] ?? '10' }}" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-primary-button>
                                {{ __('Save Settings') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
