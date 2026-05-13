<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Service Job Cards') }}
            </h2>
            <a href="{{ route('job-cards.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Create Job Card
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Job #</th>
                                    <th scope="col" class="px-6 py-3">Customer / Vehicle</th>
                                    <th scope="col" class="px-6 py-3">In Date</th>
                                    <th scope="col" class="px-6 py-3">Assigned To</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jobCards as $card)
                                    <tr class="bg-white border-b">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $card->job_card_number }}
                                        </th>
                                        <td class="px-6 py-4">
                                            <div>{{ $card->customer->first_name }} {{ $card->customer->last_name }}</div>
                                            <div class="text-xs text-gray-400">{{ $card->vehicle->registration_number }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $card->in_date }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $card->staff->first_name ?? 'Not Assigned' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                {{ ucfirst($card->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Manage</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center">No job cards found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $jobCards->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
