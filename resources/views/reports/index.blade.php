<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Business Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Financial Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Sales -->
                <div class="bg-white p-6 rounded-2xl shadow-xl border border-emerald-100 transform transition hover:scale-105">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-emerald-50 rounded-lg">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Sales</p>
                            <h3 class="text-2xl font-black text-gray-800">{{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($data['total_sales'], 2) }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Total Purchases -->
                <div class="bg-white p-6 rounded-2xl shadow-xl border border-blue-100 transform transition hover:scale-105">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Purchases</p>
                            <h3 class="text-2xl font-black text-gray-800">{{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($data['total_purchases'], 2) }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Total Expenses -->
                <div class="bg-white p-6 rounded-2xl shadow-xl border border-rose-100 transform transition hover:scale-105">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-rose-50 rounded-lg">
                            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Expenses</p>
                            <h3 class="text-2xl font-black text-gray-800">{{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($data['total_expenses'], 2) }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Net Profit -->
                <div class="bg-white p-6 rounded-2xl shadow-xl transform transition hover:scale-105">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-indigo-50 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Net Profit</p>
                            <h3 class="text-2xl font-black text-gray-800">{{ $settings['currency_symbol'] ?? '₹' }}{{ number_format($data['net_profit'], 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Visual Placeholder for Charts -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-indigo-600 rounded-full mr-3"></span>
                        Revenue Breakdown
                    </h4>
                    <div class="h-64 flex flex-col justify-center items-center text-gray-400 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                        <p class="font-medium italic">Chart visualization coming soon...</p>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-emerald-600 rounded-full mr-3"></span>
                        Monthly Growth
                    </h4>
                    <div class="h-64 flex flex-col justify-center items-center text-gray-400 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        <p class="font-medium italic">Monthly trend analysis coming soon...</p>
                    </div>
                </div>
            </div>

            <!-- Action Area -->
            <div class="mt-10 flex justify-center space-x-4">
                <button onclick="window.print()" class="px-8 py-3 bg-gray-800 text-white rounded-lg font-bold hover:bg-gray-900 shadow-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Summary Report
                </button>
                <button class="px-8 py-3 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 shadow-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download Detailed Excel
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
