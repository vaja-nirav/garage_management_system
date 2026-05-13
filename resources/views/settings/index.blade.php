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
                                <x-input-label for="site_name" :value="__('Application Name')" />
                                <x-text-input id="site_name" name="site_name" type="text" class="mt-1 block w-full" value="{{ $settings->where('key', 'site_name')->first()->value ?? 'Garage SaaS' }}" />
                            </div>

                            <div>
                                <x-input-label for="currency" :value="__('Currency Symbol')" />
                                <x-text-input id="currency" name="currency" type="text" class="mt-1 block w-full" value="{{ $settings->where('key', 'currency')->first()->value ?? '$' }}" />
                            </div>

                            <div>
                                <x-input-label for="tax_percentage" :value="__('Default Tax (%)')" />
                                <x-text-input id="tax_percentage" name="tax_percentage" type="text" class="mt-1 block w-full" value="{{ $settings->where('key', 'tax_percentage')->first()->value ?? '10' }}" />
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
