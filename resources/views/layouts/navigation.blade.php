<section class="py-4 bg-background border-b border-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ mobileMenuOpen: false }">
        <!-- Desktop Menu -->
        <nav class="hidden items-center justify-between lg:flex">
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="w-8 h-8 fill-current text-foreground" />
                    <span class="text-xl font-black tracking-normal text-foreground font-goldman">
                        {{ \App\Models\Setting::get('store_name', config('app.name')) }}
                    </span>
                </a>

                <!-- Navigation Menu -->
                <div class="flex items-center">
                    <div class="flex flex-row gap-1">
                        <!-- Dashboard Link -->
                        <a href="{{ route('dashboard') }}" class="group inline-flex h-10 w-max items-center justify-center rounded-md px-4 py-2 text-sm font-medium transition-colors hover:bg-primary hover:text-white disabled:pointer-events-none disabled:opacity-50 {{ request()->routeIs('dashboard') ? 'bg-transparent text-primary' : 'bg-background text-foreground' }}">
                            <x-heroicon-o-squares-2x2 class="mr-2 h-4 w-4" />
                            {{ __('messages.dashboard') }}
                        </a>

                        <!-- Super Admin: Companies Management -->
                        @if(Auth::user()->is_super_admin)
                        <a href="{{ route('companies.index') }}" class="group inline-flex h-10 w-max items-center justify-center rounded-md px-4 py-2 text-sm font-medium transition-colors hover:bg-primary hover:text-white disabled:pointer-events-none disabled:opacity-50 {{ request()->routeIs('companies.*') ? 'bg-transparent text-primary' : 'bg-background text-foreground' }}">
                            <x-heroicon-o-building-office-2 class="mr-2 h-4 w-4" />
                            Tenants
                        </a>

                        <a href="{{ route('users.index') }}" class="group inline-flex h-10 w-max items-center justify-center rounded-md px-4 py-2 text-sm font-medium transition-colors hover:bg-primary hover:text-white disabled:pointer-events-none disabled:opacity-50 {{ request()->routeIs('users.*') ? 'bg-transparent text-primary' : 'bg-background text-foreground' }}">
                            <x-heroicon-o-users class="mr-2 h-4 w-4" />
                            {{ __('messages.users') }}
                        </a>
                        @endif

                        <!-- Sales Dropdown -->
                        @if(!Auth::user()->is_super_admin && (Auth::user()->hasPermission('access_pos') || Auth::user()->hasPermission('view_reports')))
                        <x-nav-dropdown active="{{ request()->routeIs(['sales.*', 'customers.*']) }}">
                            <x-slot name="icon">
                                <x-heroicon-o-banknotes class="mr-2 h-4 w-4" />
                            </x-slot>
                            <x-slot name="trigger">
                                {{ t_label('sale') }}
                            </x-slot>
                            <x-slot name="content">
                                @if(Auth::user()->hasPermission('access_pos'))
                                <x-dropdown-link :href="route('sales.create')" :active="request()->routeIs('sales.create')">
                                    {{ __('messages.pos') }}
                                </x-dropdown-link>
                                @endif

                                @if(Auth::user()->hasPermission('view_reports'))
                                <x-dropdown-link :href="route('sales.index')" :active="request()->routeIs(['sales.index', 'sales.show'])">
                                    {{ __('messages.sales_list') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                                    {{ t_label('customer') }}
                                </x-dropdown-link>
                                @endif
                            </x-slot>
                        </x-nav-dropdown>
                        @endif

                        <!-- Purchases Dropdown -->
                        @if(!Auth::user()->is_super_admin && Auth::user()->hasPermission('manage_inventory'))
                        <x-nav-dropdown active="{{ request()->routeIs(['purchases.*', 'suppliers.*']) }}">
                            <x-slot name="icon">
                                <x-heroicon-o-shopping-cart class="mr-2 h-4 w-4" />
                            </x-slot>
                            <x-slot name="trigger">
                                {{ __('messages.purchases') }}
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('purchases.index')" :active="request()->routeIs('purchases.*')">
                                    {{ __('messages.purchase_list') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">
                                    {{ t_label('supplier') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-nav-dropdown>
                        @endif

                        <!-- Finance Dropdown -->
                        @if(!Auth::user()->is_super_admin && Auth::user()->hasPermission('manage_finance'))
                        <x-nav-dropdown active="{{ request()->routeIs(['finance.*']) }}">
                            <x-slot name="icon">
                                <x-heroicon-o-currency-dollar class="mr-2 h-4 w-4" />
                            </x-slot>
                            <x-slot name="trigger">
                                {{ __('messages.finance') }}
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('finance.transactions.index')" :active="request()->routeIs('finance.transactions.index')">
                                    {{ __('messages.transactions') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('finance.categories.index')" :active="request()->routeIs('finance.categories.index')">
                                    {{ __('messages.categories') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-nav-dropdown>
                        @endif

                        <!-- Users Link -->
                        @if(!Auth::user()->is_super_admin && Auth::user()->hasPermission('manage_users'))
                        <a href="{{ route('users.index') }}" class="group inline-flex h-10 w-max items-center justify-center rounded-md px-4 py-2 text-sm font-medium transition-colors hover:bg-primary hover:text-white disabled:pointer-events-none disabled:opacity-50 {{ request()->routeIs('users.*') ? 'bg-transparent text-primary' : 'bg-background text-foreground' }}">
                            <x-heroicon-o-users class="mr-2 h-4 w-4" />
                            {{ __('messages.users') }}
                        </a>
                        @endif

                        <!-- Products Dropdown -->
                        @if(!Auth::user()->is_super_admin && Auth::user()->hasPermission('manage_inventory'))
                        <x-nav-dropdown active="{{ request()->routeIs(['products.*', 'categories.*', 'units.*']) }}">
                            <x-slot name="icon">
                                <x-heroicon-o-cube class="mr-2 h-4 w-4" />
                            </x-slot>
                            <x-slot name="trigger">
                                {{ t_label('product') }}
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                                    {{ __('messages.product_list') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                                    {{ __('messages.categories') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('units.index')" :active="request()->routeIs('units.*')">
                                    {{ __('messages.units') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-nav-dropdown>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Auth Buttons -->
            <div class="flex items-center gap-4">
                <!-- Language Switcher -->
                <div class="flex items-center">
                    @if(app()->getLocale() == 'en')
                        <a href="{{ route('language.switch', 'id') }}" class="text-xs font-bold px-2 py-1 rounded-md hover:bg-muted text-muted-foreground flex items-center gap-1">
                            <span class="text-foreground">EN</span>
                            <span class="opacity-50">ID</span>
                        </a>
                    @else
                        <a href="{{ route('language.switch', 'en') }}" class="text-xs font-bold px-2 py-1 rounded-md hover:bg-muted text-muted-foreground flex items-center gap-1">
                            <span class="opacity-50">EN</span>
                            <span class="text-foreground">ID</span>
                        </a>
                    @endif
                </div>

                <button
                    x-data="{
                        theme: localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),
                        toggleTheme() {
                            this.theme = this.theme === 'dark' ? 'light' : 'dark';
                            localStorage.setItem('theme', this.theme);
                            if (this.theme === 'dark') {
                                document.documentElement.classList.add('dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                            }
                        }
                    }"
                    @click="toggleTheme()"
                    class="rounded-md p-2 text-muted-foreground hover:bg-muted hover:text-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                >
                    <x-heroicon-o-sun x-show="theme === 'dark'" class="h-5 w-5" style="display: none;" />
                    <x-heroicon-o-moon x-show="theme === 'light'" class="h-5 w-5" />
                </button>

                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center justify-center whitespace-nowrap rounded-full text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:opacity-80 transition-opacity">
                            <x-avatar :name="Auth::user()->name" />
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-border mb-1 bg-muted/30">
                            <p class="text-sm text-center font-semibold text-foreground truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-muted-foreground truncate">{{ Auth::user()->email }}</p>
                            @if(Auth::user()->is_super_admin)
                                <span class="mt-1 inline-flex items-center rounded-full bg-primary/10 px-2 py-0.5 text-[10px] font-medium text-primary">Platform Admin</span>
                            @else
                                <span class="mt-1 inline-flex items-center rounded-full bg-muted px-2 py-0.5 text-[10px] font-medium text-muted-foreground uppercase">{{ Auth::user()->company->name }}</span>
                            @endif
                        </div>

                        <x-dropdown-link :href="route('profile.index')" :active="request()->routeIs('profile.*')">
                            {{ __('messages.profile') }}
                        </x-dropdown-link>

                        @if(Auth::user()->hasPermission('manage_settings'))
                        <x-dropdown-link :href="route('settings.index')" :active="request()->routeIs('settings.*')">
                            {{ __('messages.settings') }}
                        </x-dropdown-link>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('messages.logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div class="block lg:hidden">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="w-8 h-8 fill-current text-foreground" />
                </a>

                <div class="flex items-center gap-2">
                    <!-- Language Switcher Mobile Moved to Top Bar -->
                    @if(app()->getLocale() == 'en')
                        <a href="{{ route('language.switch', 'id') }}" class="text-[10px] font-bold px-2 py-1 rounded-md bg-muted text-muted-foreground">
                            <span class="text-foreground">EN</span>/<span class="opacity-50">ID</span>
                        </a>
                    @else
                        <a href="{{ route('language.switch', 'en') }}" class="text-[10px] font-bold px-2 py-1 rounded-md bg-muted text-muted-foreground">
                            <span class="opacity-50">EN</span>/<span class="text-foreground">ID</span>
                        </a>
                    @endif

                    <button @click="mobileMenuOpen = true" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 w-10">
                        <x-heroicon-o-bars-3 class="h-4 w-4" />
                    </button>
                </div>
            </div>

            <!-- Mobile Sheet/Drawer -->
            <div x-show="mobileMenuOpen"
                x-transition:enter="duration-300 ease-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="duration-200 ease-in"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 bg-background/80 backdrop-blur-sm"
                style="display: none;"
                @click="mobileMenuOpen = false">
            </div>

            <div x-show="mobileMenuOpen"
                x-transition:enter="duration-500 ease-in-out"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="duration-500 ease-in-out"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="fixed inset-y-0 right-0 z-50 h-full w-3/4 flex flex-col border-l bg-background shadow-lg sm:max-w-sm"
                style="display: none;"
                @click.stop>

                <!-- Mobile Header -->
                <div class="p-6 border-b border-border flex items-center justify-between">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="w-8 h-8 fill-current text-foreground" />
                        <span class="text-xl font-bold tracking-tighter font-goldman">
                            {{ \App\Models\Setting::get('store_name', config('app.name')) }}
                        </span>
                    </a>
                    <button @click="mobileMenuOpen = false" class="rounded-sm opacity-70 transition-opacity hover:opacity-100">
                        <x-heroicon-o-x-mark class="h-5 w-5" />
                    </button>
                </div>

                <!-- Scrollable Navigation Area -->
                <div class="flex-1 overflow-y-auto p-6">
                    <nav class="flex flex-col gap-4">
                        <a href="{{ route('dashboard') }}" class="text-md font-semibold hover:text-primary {{ request()->routeIs('dashboard') ? 'text-primary' : '' }}">{{ __('messages.dashboard') }}</a>

                        <!-- Super Admin Mobile Links -->
                        @if(Auth::user()->is_super_admin)
                        <a href="{{ route('companies.index') }}" class="text-md font-semibold hover:text-primary {{ request()->routeIs('companies.*') ? 'text-primary' : '' }}">Tenants</a>
                        <a href="{{ route('users.index') }}" class="text-md font-semibold hover:text-primary {{ request()->routeIs('users.*') ? 'text-primary' : '' }}">{{ __('messages.users') }}</a>
                        @endif

                        @if(!Auth::user()->is_super_admin)
                            <!-- Mobile Sales Accordion -->
                            @if(Auth::user()->hasPermission('access_pos') || Auth::user()->hasPermission('view_reports'))
                            <div x-data="{ expanded: {{ request()->routeIs(['sales.*', 'customers.*']) ? 'true' : 'false' }} }">
                                <button @click="expanded = !expanded" class="flex items-center justify-between w-full text-left text-md font-semibold {{ request()->routeIs(['sales.*', 'customers.*']) ? 'text-primary' : '' }}">
                                    {{ t_label('sale') }}
                                    <x-heroicon-o-chevron-down :class="{'rotate-180': expanded}" class="h-4 w-4 transition-transform duration-200" />
                                </button>
                                <div x-show="expanded" x-collapse class="mt-2 pl-4 border-l border-border ml-2 flex flex-col gap-2 text-sm font-medium">
                                    @if(Auth::user()->hasPermission('access_pos'))
                                    <a class="py-1 {{ request()->routeIs('sales.create') ? 'text-primary' : '' }}" href="{{ route('sales.create') }}">{{ __('messages.pos') }}</a>
                                    @endif
                                    @if(Auth::user()->hasPermission('view_reports'))
                                    <a class="py-1 {{ request()->routeIs(['sales.index', 'sales.show']) ? 'text-primary' : '' }}" href="{{ route('sales.index') }}">{{ __('messages.sales_list') }}</a>
                                    <a class="py-1 {{ request()->routeIs('customers.index') ? 'text-primary' : '' }}" href="{{ route('customers.index') }}">{{ t_label('customer') }}</a>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Mobile Purchases Accordion -->
                            @if(Auth::user()->hasPermission('manage_inventory'))
                            <div x-data="{ expanded: {{ request()->routeIs(['purchases.*', 'suppliers.*']) ? 'true' : 'false' }} }">
                                <button @click="expanded = !expanded" class="flex items-center justify-between w-full text-left text-md font-semibold {{ request()->routeIs(['purchases.*', 'suppliers.*']) ? 'text-primary' : '' }}">
                                    {{ __('messages.purchases') }}
                                    <x-heroicon-o-chevron-down :class="{'rotate-180': expanded}" class="h-4 w-4 transition-transform duration-200" />
                                </button>
                                <div x-show="expanded" x-collapse class="mt-2 pl-4 border-l border-border ml-2 flex flex-col gap-2 text-sm font-medium">
                                    <a class="py-1 {{ request()->routeIs('purchases.index') ? 'text-primary' : '' }}" href="{{ route('purchases.index') }}">{{ __('messages.purchase_list') }}</a>
                                    <a class="py-1 {{ request()->routeIs('suppliers.index') ? 'text-primary' : '' }}" href="{{ route('suppliers.index') }}">{{ t_label('supplier') }}</a>
                                </div>
                            </div>
                            @endif

                            <!-- Mobile Finance Accordion -->
                            @if(Auth::user()->hasPermission('manage_finance'))
                            <div x-data="{ expanded: {{ request()->routeIs(['finance.*']) ? 'true' : 'false' }} }">
                                <button @click="expanded = !expanded" class="flex items-center justify-between w-full text-left text-md font-semibold {{ request()->routeIs(['finance.*']) ? 'text-primary' : '' }}">
                                    {{ __('messages.finance') }}
                                    <x-heroicon-o-chevron-down :class="{'rotate-180': expanded}" class="h-4 w-4 transition-transform duration-200" />
                                </button>
                                <div x-show="expanded" x-collapse class="mt-2 pl-4 border-l border-border ml-2 flex flex-col gap-2 text-sm font-medium">
                                    <a class="py-1 {{ request()->routeIs('finance.transactions.index') ? 'text-primary' : '' }}" href="{{ route('finance.transactions.index') }}">{{ __('messages.transactions') }}</a>
                                    <a class="py-1 {{ request()->routeIs('finance.categories.index') ? 'text-primary' : '' }}" href="{{ route('finance.categories.index') }}">{{ __('messages.categories') }}</a>
                                </div>
                            </div>
                            @endif

                            <!-- Mobile Products Accordion -->
                            @if(Auth::user()->hasPermission('manage_inventory'))
                            <div x-data="{ expanded: {{ request()->routeIs(['products.*', 'categories.*', 'units.*']) ? 'true' : 'false' }} }">
                                <button @click="expanded = !expanded" class="flex items-center justify-between w-full text-left text-md font-semibold {{ request()->routeIs(['products.*', 'categories.*', 'units.*']) ? 'text-primary' : '' }}">
                                    {{ t_label('product') }}
                                    <x-heroicon-o-chevron-down :class="{'rotate-180': expanded}" class="h-4 w-4 transition-transform duration-200" />
                                </button>
                                <div x-show="expanded" x-collapse class="mt-2 pl-4 border-l border-border ml-2 flex flex-col gap-2 text-sm font-medium">
                                    <a class="py-1 {{ request()->routeIs('products.index') ? 'text-primary' : '' }}" href="{{ route('products.index') }}">{{ __('messages.product_list') }}</a>
                                    <a class="py-1 {{ request()->routeIs('categories.index') ? 'text-primary' : '' }}" href="{{ route('categories.index') }}">{{ __('messages.categories') }}</a>
                                    <a class="py-1 {{ request()->routeIs('units.index') ? 'text-primary' : '' }}" href="{{ route('units.index') }}">{{ __('messages.units') }}</a>
                                </div>
                            </div>
                            @endif

                            <!-- Mobile Users Link -->
                            @if(Auth::user()->hasPermission('manage_users'))
                            <a href="{{ route('users.index') }}" class="text-md font-semibold hover:text-primary {{ request()->routeIs('users.*') ? 'text-primary' : '' }}">{{ __('messages.users') }}</a>
                            @endif
                        @endif
                    </nav>
                </div>

                <!-- Fixed Bottom User Area -->
                <div class="p-6 border-t border-border bg-muted/20">
                    <div class="flex items-center gap-3 mb-4">
                        <x-avatar :name="Auth::user()->name" class="w-10 h-10" />
                        <div class="overflow-hidden">
                            <p class="text-sm font-bold text-foreground truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-muted-foreground truncate uppercase tracking-widest">{{ Auth::user()->is_super_admin ? 'Platform Admin' : Auth::user()->company->name }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mb-3">
                        <a href="{{ route('profile.index') }}" class="flex items-center justify-center h-9 rounded-md border border-border bg-background text-xs font-semibold hover:bg-muted transition-colors">
                            {{ __('messages.profile') }}
                        </a>
                        @if(Auth::user()->hasPermission('manage_settings'))
                        <a href="{{ route('settings.index') }}" class="flex items-center justify-center h-9 rounded-md border border-border bg-background text-xs font-semibold hover:bg-muted transition-colors">
                            {{ __('messages.settings') }}
                        </a>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center h-10 rounded-md bg-primary text-primary-foreground text-sm font-bold hover:bg-primary/90 transition-all active:scale-[0.98]">
                            <x-heroicon-o-arrow-left-on-rectangle class="w-4 h-4 mr-2" />
                            {{ __('messages.logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
