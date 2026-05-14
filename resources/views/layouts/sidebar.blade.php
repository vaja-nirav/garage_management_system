<div class="flex flex-col w-64 bg-[#0f172a] h-screen sticky top-0 overflow-y-auto no-scrollbar shadow-2xl border-r border-white/5">
    <!-- Logo Section -->
    <div class="flex items-center mt-8 px-6 justify-start h-16">
        <div class="flex items-center space-x-3 group cursor-pointer">
            <a href="{{ route('dashboard') }}">
            <div class="p-2 bg-indigo-500 rounded-xl shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            </a>
            <div class="flex flex-col">
                <a href="{{ route('dashboard') }}">
                <span class="text-white font-bold text-lg tracking-tight leading-none">{{ $settings['app_name'] ?? 'GaragePro' }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Section -->
    <div class="flex flex-col flex-1 mt-10">
        <nav class="flex-1 px-4 pb-10 space-y-1">
            <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="dashboard">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                {{ __('Dashboard') }}
            </x-sidebar-link>

            @if(auth()->user()->can('view plans') || auth()->user()->can('view garages') || auth()->user()->can('view subscriptions'))
            <div class="pt-6 pb-2 px-4">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Administration</span>
            </div>

            @can('view plans')
            <x-sidebar-link :href="route('plans.index')" :active="request()->routeIs('plans.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                {{ __('Subscription Plans') }}
            </x-sidebar-link>
            @endcan

            @can('view garages')
            <x-sidebar-link :href="route('garages.index')" :active="request()->routeIs('garages.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                {{ __('Garages') }}
            </x-sidebar-link>
            @endcan

            @can('view subscriptions')
            <x-sidebar-link :href="route('subscriptions.index')" :active="request()->routeIs('subscriptions.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                {{ __('Subscriptions') }}
            </x-sidebar-link>
            @endcan
            @endif

            @if(auth()->user()->can('view customers') || auth()->user()->can('view vehicles') || auth()->user()->can('view staff'))
            <div class="pt-6 pb-2 px-4">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">CRM & Staff</span>
            </div>

            @can('view customers')
            <x-sidebar-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                {{ __('Customers') }}
            </x-sidebar-link>
            @endcan

            @can('view vehicles')
            <x-sidebar-link :href="route('vehicles.index')" :active="request()->routeIs('vehicles.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                {{ __('Vehicles') }}
            </x-sidebar-link>
            @endcan

            @can('view staff')
            <x-sidebar-link :href="route('staff.index')" :active="request()->routeIs('staff.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                {{ __('Staff / Mechanics') }}
            </x-sidebar-link>
            @endcan
            @endif

            @if(auth()->user()->can('view categories') || auth()->user()->can('view products') || auth()->user()->can('view suppliers'))
            <div class="pt-6 pb-2 px-4">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Inventory</span>
            </div>

            @can('view categories')
            <x-sidebar-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                {{ __('Categories') }}
            </x-sidebar-link>
            @endcan

            @can('view products')
            <x-sidebar-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                {{ __('Products') }}
            </x-sidebar-link>
            @endcan

            @can('view suppliers')
            <x-sidebar-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ __('Suppliers') }}
            </x-sidebar-link>
            @endcan
            @endif
            
            @if(auth()->user()->can('view purchases') || auth()->user()->can('view sales') || auth()->user()->can('view appointments') || auth()->user()->can('view job_cards'))
            <div class="pt-6 pb-2 px-4">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Operations</span>
            </div>
            
            @can('view purchases')
            <x-sidebar-link :href="route('purchases.index')" :active="request()->routeIs('purchases.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                {{ __('Purchases') }}
            </x-sidebar-link>
            @endcan
            
            @can('view purchase_returns')
            <x-sidebar-link :href="route('purchase-returns.index')" :active="request()->routeIs('purchase-returns.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                {{ __('Purchase Returns') }}
            </x-sidebar-link>
            @endcan
            
            @can('view sales')
            <x-sidebar-link :href="route('sales.index')" :active="request()->routeIs('sales.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                {{ __('Sales / Billing') }}
            </x-sidebar-link>
            @endcan

            @can('view sale_returns')
            <x-sidebar-link :href="route('sale-returns.index')" :active="request()->routeIs('sale-returns.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                {{ __('Sale Returns') }}
            </x-sidebar-link>
            @endcan

            @can('view appointments')
            <x-sidebar-link :href="route('appointments.index')" :active="request()->routeIs('appointments.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                {{ __('Appointments') }}
            </x-sidebar-link>
            @endcan

            @can('view job_cards')
            <x-sidebar-link :href="route('job-cards.index')" :active="request()->routeIs('job-cards.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                {{ __('Job Cards') }}
            </x-sidebar-link>
            @endcan
            @endif

            @if(auth()->user()->can('view expenses') || auth()->user()->can('view reports') || auth()->user()->can('view settings') || auth()->user()->can('view roles'))
            <div class="pt-6 pb-2 px-4">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Financials & System</span>
            </div>

            @can('view expenses')
            <x-sidebar-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                {{ __('Expenses') }}
            </x-sidebar-link>
            @endcan

            @can('view reports')
            <x-sidebar-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>    
                {{ __('Reports') }}
            </x-sidebar-link>
            @endcan

            @can('view settings')
            <x-sidebar-link :href="route('settings.index')" :active="request()->routeIs('settings.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                {{ __('Settings') }}
            </x-sidebar-link>
            @endcan

            @can('view roles')
            <x-sidebar-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                {{ __('Roles & Permissions') }}
            </x-sidebar-link>
            @endcan
            @endif

        </nav>
    </div>
</div>
