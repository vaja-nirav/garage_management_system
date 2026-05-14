<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Sale Returns') }}
            </h2>
            @can('create sale_returns')
            <a href="{{ route('sale-returns.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg transform transition hover:scale-105 active:scale-95">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Sale Return
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="p-0">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4 font-black">Return #</th>
                                    <th class="px-6 py-4 font-black">Invoice #</th>
                                    <th class="px-6 py-4 font-black">Customer</th>
                                    <th class="px-6 py-4 font-black">Date</th>
                                    <th class="px-6 py-4 font-black text-right">Amount</th>
                                    <th class="px-6 py-4 font-black text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($returns as $return)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <span class="font-black text-slate-800">{{ $return->return_number }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-indigo-600">
                                        <a href="{{ route('sales.index') }}" class="hover:underline">
                                            {{ $return->sale->sale_number }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-700">{{ $return->sale->customer->first_name }} {{ $return->sale->customer->last_name }}</span>
                                            <span class="text-[10px] text-slate-400">{{ $return->sale->customer->phone }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">
                                        {{ \Carbon\Carbon::parse($return->return_date)->format('d M, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="font-black text-slate-900">{{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($return->amount, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            @can('delete sale_returns')
                                            <form action="{{ route('sale-returns.destroy', $return->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this return record? This will NOT revert stock automatically.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Delete Record">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                                            </div>
                                            <p class="text-slate-500 font-medium">No sale returns recorded yet.</p>
                                            <p class="text-slate-400 text-xs mt-1">Start by clicking the "New Sale Return" button above.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($returns->hasPages())
                    <div class="p-6 border-t border-slate-50">
                        {{ $returns->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
