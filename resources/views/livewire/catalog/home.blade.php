<div>
    <!-- Hero Section with Background Image -->
    <div class="relative bg-card overflow-hidden">
        <!-- Background Image Container -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/beranda.png') }}" class="w-full h-full object-cover" alt="Hero Background">
            <!-- Overlay for readability -->
            <div class="absolute inset-0 bg-black/60 dark:bg-black/70 bg-gradient-to-r from-black/80 to-transparent"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24 md:py-32 lg:py-48">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <div class="sm:text-center md:mx-auto md:max-w-2xl lg:col-span-8 lg:text-left">
                    <h1>
                        <span class="block text-base font-black text-primary uppercase tracking-[0.3em] mb-4">{{ \App\Models\Setting::get('store_name') }}</span>
                        <span class="mt-1 block text-4xl font-black tracking-tight text-white sm:text-6xl xl:text-7xl leading-[1.1]">
                            {{ __('messages.hero_title') }}
                        </span>
                    </h1>
                    <p class="mt-6 text-lg text-gray-300 sm:mt-8 sm:text-2xl lg:text-xl xl:text-2xl max-w-3xl leading-relaxed">
                        {{ __('messages.hero_subtitle') }}
                    </p>
                    <div class="mt-10 sm:mx-auto sm:max-w-lg sm:text-center lg:mx-0 lg:text-left flex flex-wrap gap-5">
                        <a href="{{ route('catalog') }}" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-black rounded-xl shadow-2xl text-primary-foreground bg-primary hover:bg-primary/90 hover:scale-105 transition-all uppercase tracking-widest">
                            {{ __('messages.shop_now') }}
                            <x-heroicon-o-arrow-right class="ml-2 h-6 w-6" />
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-8 py-4 border-2 border-white/20 text-lg font-black rounded-xl text-white bg-white/10 backdrop-blur-md hover:bg-white/20 hover:scale-105 transition-all uppercase tracking-widest">
                            {{ __('messages.contact') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Categories -->
    <div class="bg-muted/30 py-24 border-b border-border">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-foreground uppercase tracking-widest">{{ __('messages.featured_categories') }}</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                @foreach($featuredCategories as $category)
                    <a href="{{ route('catalog', ['category_id' => $category->id]) }}" class="group block">
                        <div class="relative overflow-hidden rounded-2xl bg-card border border-border p-8 text-center transition-all hover:shadow-lg hover:-translate-y-1">
                            <div class="mx-auto h-12 w-12 text-primary group-hover:scale-110 transition-transform">
                                <x-heroicon-o-tag />
                            </div>
                            <h3 class="mt-4 text-lg font-bold text-foreground uppercase">{{ $category->name }}</h3>
                            <p class="mt-1 text-sm text-muted-foreground">{{ $category->products_count }} {{ __('messages.products_count_label') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="py-24 bg-background">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base font-semibold tracking-[0.2em] text-primary uppercase">{{ __('messages.why_choose_us') }}</h2>
                <p class="mt-2 text-4xl leading-8 font-black tracking-tight text-foreground sm:text-5xl uppercase">
                    {{ __('messages.trusted_construction_solutions') }}
                </p>
            </div>

            <div class="mt-20">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-12 md:gap-y-10">
                    <div class="relative p-8 bg-card rounded-2xl border border-border shadow-sm hover:shadow-md transition-shadow">
                        <dt>
                            <div class="absolute flex items-center justify-center h-14 w-14 rounded-xl bg-primary text-primary-foreground shadow-lg shadow-primary/20">
                                <x-heroicon-o-shield-check class="h-8 w-8" />
                            </div>
                            <p class="ml-20 text-xl leading-6 font-black text-foreground uppercase tracking-tight">{{ __('messages.quality_guaranteed') }}</p>
                        </dt>
                        <dd class="mt-4 ml-20 text-base text-muted-foreground leading-relaxed">
                            {{ __('messages.quality_guaranteed_desc') }}
                        </dd>
                    </div>

                    <div class="relative p-8 bg-card rounded-2xl border border-border shadow-sm hover:shadow-md transition-shadow">
                        <dt>
                            <div class="absolute flex items-center justify-center h-14 w-14 rounded-xl bg-primary text-primary-foreground shadow-lg shadow-primary/20">
                                <x-heroicon-o-currency-dollar class="h-8 w-8" />
                            </div>
                            <p class="ml-20 text-xl leading-6 font-black text-foreground uppercase tracking-tight">{{ __('messages.competitive_prices') }}</p>
                        </dt>
                        <dd class="mt-4 ml-20 text-base text-muted-foreground leading-relaxed">
                            {{ __('messages.competitive_prices_desc') }}
                        </dd>
                    </div>

                    <div class="relative p-8 bg-card rounded-2xl border border-border shadow-sm hover:shadow-md transition-shadow">
                        <dt>
                            <div class="absolute flex items-center justify-center h-14 w-14 rounded-xl bg-primary text-primary-foreground shadow-lg shadow-primary/20">
                                <x-heroicon-o-truck class="h-6 w-6" />
                            </div>
                            <p class="ml-20 text-xl leading-6 font-black text-foreground uppercase tracking-tight">{{ __('messages.fast_delivery') }}</p>
                        </dt>
                        <dd class="mt-4 ml-20 text-base text-muted-foreground leading-relaxed">
                            {{ __('messages.fast_delivery_desc') }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
