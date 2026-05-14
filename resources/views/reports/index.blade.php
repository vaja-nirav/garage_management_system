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
                <!-- Revenue Breakdown Chart -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-2 h-8 bg-indigo-600 rounded-full mr-3"></span>
                        Revenue Breakdown (Last 6 Months)
                    </h4>
                    <div class="h-64">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Monthly Growth Chart -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-lg font-bold text-gray-800 flex items-center">
                            <span class="w-2 h-8 bg-emerald-600 rounded-full mr-3"></span>
                            Sales vs Expenses
                        </h4>
                        <select id="chartTypeToggle" class="text-xs border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition-all cursor-pointer">
                            <option value="bar">Bar Chart</option>
                            <option value="line">Line Chart</option>
                        </select>
                    </div>
                    <div class="h-64">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Action Area -->
            <div class="mt-10 flex justify-center space-x-4">
                <a href="{{ route('reports.pdf') }}" target="_blank" class="px-8 py-3 bg-gray-800 text-white rounded-lg font-bold hover:bg-gray-900 shadow-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Summary Report
                </a>
                <a href="{{ route('reports.excel') }}" class="px-8 py-3 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 shadow-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download Detailed Excel
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData);

            // Revenue Chart (Doughnut)
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Sales', 'Purchases', 'Expenses'],
                    datasets: [{
                        data: [
                            {{ $data['total_sales'] }}, 
                            {{ $data['total_purchases'] }}, 
                            {{ $data['total_expenses'] }}
                        ],
                        backgroundColor: ['#10b981', '#3b82f6', '#f43f5e'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    },
                    cutout: '70%'
                }
            });

            // Growth Chart (Bar + Line)
            const growthCtx = document.getElementById('growthChart').getContext('2d');
            const growthChart = new Chart(growthCtx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        {
                            label: 'Sales',
                            data: chartData.sales,
                            backgroundColor: 'rgba(16, 185, 129, 0.8)',
                            borderColor: '#10b981',
                            borderWidth: 1,
                            borderRadius: 6,
                        },
                        {
                            label: 'Expenses',
                            data: chartData.expenses,
                            backgroundColor: 'rgba(244, 63, 94, 0.8)',
                            borderColor: '#f43f5e',
                            borderWidth: 1,
                            borderRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            },
                            ticks: {
                                callback: function(value, index, values) {
                                    if (value >= 1000) {
                                        return (value / 1000).toFixed(value % 1000 === 0 ? 0 : 1) + 'k';
                                    }
                                    return value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Toggle Chart Type
            document.getElementById('chartTypeToggle').addEventListener('change', function() {
                const newType = this.value;
                
                growthChart.data.datasets.forEach((dataset) => {
                    dataset.type = newType;
                    if (newType === 'line') {
                        dataset.fill = true;
                        dataset.tension = 0.4;
                        dataset.borderWidth = 2;
                        if (dataset.label === 'Sales') {
                            dataset.backgroundColor = 'rgba(16, 185, 129, 0.1)';
                        } else {
                            dataset.backgroundColor = 'rgba(244, 63, 94, 0.1)';
                        }
                    } else {
                        dataset.fill = false;
                        dataset.borderWidth = 1;
                        if (dataset.label === 'Sales') {
                            dataset.backgroundColor = 'rgba(16, 185, 129, 0.8)';
                        } else {
                            dataset.backgroundColor = 'rgba(244, 63, 94, 0.8)';
                        }
                    }
                });
                
                growthChart.update();
            });
        });
    </script>
    @endpush
</x-app-layout>
