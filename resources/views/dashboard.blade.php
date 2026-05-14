<x-app-layout>
    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Dashboard</h1>
                <p class="text-slate-500 font-medium mt-1">Welcome back, <span class="text-indigo-600 font-bold">{{ Auth::user()->name }}</span>! Here's what's happening today.</p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Total Customers -->
            @can('view customers')
            <a href="{{ route('customers.index') }}" class="glass-card p-6 group hover:border-blue-500/50 transition-all duration-300 cursor-pointer block">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-600 group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="flex items-center text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">
                        Customers
                    </span>
                </div>
                <h3 class="text-slate-500 text-sm font-bold uppercase tracking-wider">Total Customers</h3>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $stats['total_customers'] }}</p>
            </a>
            @endcan

            <!-- Active Job Cards -->
            @can('view job_cards')
            <a href="{{ route('job-cards.index') }}" class="glass-card p-6 group hover:border-amber-500/50 transition-all duration-300 cursor-pointer block">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-amber-50 text-amber-600 group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <span class="flex items-center text-xs font-bold text-slate-500 bg-slate-50 px-2 py-1 rounded-lg">
                        In Progress
                    </span>
                </div>
                <h3 class="text-slate-500 text-sm font-bold uppercase tracking-wider">Active Jobs</h3>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $stats['active_job_cards'] }}</p>
            </a>
            @endcan

            <!-- Total Revenue -->
            @can('view reports')
            <a href="{{ route('sales.index') }}" class="glass-card p-6 group hover:border-emerald-500/50 transition-all duration-300 cursor-pointer block">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600 group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="flex items-center text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">
                        Monthly
                    </span>
                </div>
                <h3 class="text-slate-500 text-sm font-bold uppercase tracking-wider">Total Revenue</h3>
                <p class="text-3xl font-black text-slate-900 mt-1">${{ number_format($stats['total_revenue'], 2) }}</p>
            </a>
            @endcan

            <!-- Low Stock -->
            @can('view products')
            <a href="{{ route('products.index') }}" class="glass-card p-6 group hover:border-rose-500/50 transition-all duration-300 cursor-pointer block">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-rose-50 text-rose-600 group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <span class="flex items-center text-xs font-bold text-rose-500 bg-rose-50 px-2 py-1 rounded-lg">
                        Critical
                    </span>
                </div>
                <h3 class="text-slate-500 text-sm font-bold uppercase tracking-wider">Low Stock Products</h3>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $stats['low_stock_products'] }}</p>
            </a>
            @endcan
        </div>

        <!-- Main Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-1 gap-8">
            <!-- Quick Actions -->
            <div class="lg:col-span-2">
                <div class="glass-card overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50">
                        <h3 class="text-lg font-black text-slate-800">Quick Actions</h3>
                    </div>
                    <div class="p-8 grid grid-cols-2 md:grid-cols-4 gap-6">
                        @can('create job_cards')
                        <a href="{{ route('job-cards.create') }}" class="flex flex-col items-center justify-center p-6 rounded-2xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 group">
                            <svg class="w-8 h-8 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <span class="text-xs font-bold uppercase tracking-widest text-center">New Job Card</span>
                        </a>
                        @endcan

                        @can('create sales')
                        <a href="{{ route('sales.create') }}" class="flex flex-col items-center justify-center p-6 rounded-2xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all duration-300 group">
                            <svg class="w-8 h-8 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-xs font-bold uppercase tracking-widest text-center">New Sale</span>
                        </a>
                        @endcan

                        @can('create customers')
                        <a href="{{ route('customers.create') }}" class="flex flex-col items-center justify-center p-6 rounded-2xl bg-purple-50 text-purple-600 hover:bg-purple-600 hover:text-white transition-all duration-300 group">
                            <svg class="w-8 h-8 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            <span class="text-xs font-bold uppercase tracking-widest text-center">Add Customer</span>
                        </a>
                        @endcan

                        @can('create appointments')
                        <a href="{{ route('appointments.create') }}" class="flex flex-col items-center justify-center p-6 rounded-2xl bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white transition-all duration-300 group">
                            <svg class="w-8 h-8 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-xs font-bold uppercase tracking-widest text-center">Book Appt.</span>
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
