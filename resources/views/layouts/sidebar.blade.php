<div class="flex flex-col w-64 bg-gray-900 h-screen sticky top-0 overflow-y-auto no-scrollbar">
    <div class="flex items-center mt-5 justify-center h-16 bg-gray-900 border-b border-gray-800">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-white" />
        </a>
        <span class="text-white ml-2 font-bold text-lg">Garage SaaS</span>
    </div>
    <div class="flex flex-col flex-1 mt-6">
        <nav class="flex-1 px-4 space-y-2">
            <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="dashboard">
                {{ __('Dashboard') }}
            </x-sidebar-link>

            <div class="pt-4 pb-2">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-2">Administration</span>
            </div>

            <x-sidebar-link :href="route('plans.index')" :active="request()->routeIs('plans.*')" icon="plans">
                {{ __('Subscription Plans') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('garages.index')" :active="request()->routeIs('garages.*')" icon="garages">
                {{ __('Garages') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('subscriptions.index')" :active="request()->routeIs('subscriptions.*')" icon="subscriptions">
                {{ __('Subscriptions') }}
            </x-sidebar-link>

            <div class="pt-4 pb-2">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-2">CRM & Staff</span>
            </div>

            <x-sidebar-link :href="route('customers.index')" :active="request()->routeIs('customers.*')" icon="customers">
                {{ __('Customers') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('vehicles.index')" :active="request()->routeIs('vehicles.*')" icon="vehicles">
                {{ __('Vehicles') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('staff.index')" :active="request()->routeIs('staff.*')" icon="staff">
                {{ __('Staff / Mechanics') }}
            </x-sidebar-link>

            <div class="pt-4 pb-2">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-2">Inventory</span>
            </div>

            <x-sidebar-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" icon="categories">
                {{ __('Categories') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('products.index')" :active="request()->routeIs('products.*')" icon="products">
                {{ __('Products') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')" icon="suppliers">
                {{ __('Suppliers') }}
            </x-sidebar-link>
            
            <div class="pt-4 pb-2">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-2">Operations</span>
            </div>
            
            <x-sidebar-link :href="route('purchases.index')" :active="request()->routeIs('purchases.*')" icon="purchases">
                {{ __('Purchases') }}
            </x-sidebar-link>
            
            <x-sidebar-link :href="route('purchase-returns.index')" :active="request()->routeIs('purchase-returns.*')" icon="returns">
                {{ __('Purchase Returns') }}
            </x-sidebar-link>
            
            <x-sidebar-link :href="route('sales.index')" :active="request()->routeIs('sales.*')" icon="sales">
                {{ __('Sales / Billing') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('sale-returns.index')" :active="request()->routeIs('sale-returns.*')" icon="returns">
                {{ __('Sale Returns') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('appointments.index')" :active="request()->routeIs('appointments.*')" icon="appointments">
                {{ __('Appointments') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('job-cards.index')" :active="request()->routeIs('job-cards.*')" icon="jobcards">
                {{ __('Job Cards') }}
            </x-sidebar-link>

            <div class="pt-4 pb-2">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-2">Financials & System</span>
            </div>

            <x-sidebar-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')" icon="expenses">
                {{ __('Expenses') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" icon="reports">
                {{ __('Reports') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('settings.index')" :active="request()->routeIs('settings.*')" icon="settings">
                {{ __('Settings') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('roles.index')" :active="request()->routeIs('roles.*')" icon="roles">
                {{ __('Roles & Permissions') }}
            </x-sidebar-link>

        </nav>
    </div>
</div>
