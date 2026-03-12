<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold tracking-tight text-foreground sm:text-5xl">
                {{ __('messages.product_catalog') }}
            </h1>
            <p class="mt-4 text-xl text-muted-foreground max-w-2xl mx-auto">
                {{ __('messages.browse_products') }}
            </p>
        </div>

        <!-- Filters -->
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-heroicon-o-magnifying-glass class="h-5 w-5 text-muted-foreground" />
                </div>
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    class="block w-full pl-10 pr-3 py-2.5 border border-input rounded-lg bg-card text-foreground placeholder:text-muted-foreground focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm transition-all"
                    placeholder="{{ __('messages.search_catalog') }}"
                >
            </div>
            <div class="w-full md:w-64">
                <select
                    wire:model.live="category_id"
                    class="block w-full py-2.5 pl-3 pr-10 border border-input rounded-lg bg-card text-foreground focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm transition-all cursor-pointer"
                >
                    <option value="">{{ __('messages.all_categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="group relative bg-card rounded-2xl border border-border overflow-hidden flex flex-col transition-all hover:shadow-xl hover:-translate-y-1">
                        <!-- Product Info -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-muted text-muted-foreground">
                                    {{ $product->category->name }}
                                </span>
                                @if($product->quantity <= $product->min_stock && $product->quantity > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                                        {{ __('messages.low_stock') }}
                                    </span>
                                @elseif($product->quantity <= 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        {{ __('messages.out_of_stock') }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-lg font-bold text-foreground leading-tight group-hover:text-primary transition-colors mb-1">
                                {{ $product->name }}
                            </h3>
                            <p class="text-xs text-muted-foreground mb-4 font-mono">{{ $product->sku }}</p>

                            @if($product->description)
                                <p class="text-sm text-muted-foreground line-clamp-2 mb-4">
                                    {{ $product->description }}
                                </p>
                            @endif

                            <div class="mt-auto pt-4 border-t border-border flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-2xl font-black text-foreground">
                                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-muted-foreground">
                                        per {{ $product->unit->name }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs font-semibold {{ $product->quantity > $product->min_stock ? 'text-green-600 dark:text-green-400' : ($product->quantity > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">
                                        {{ $product->quantity }} {{ $product->unit->symbol }} {{ __('messages.available') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-24 bg-card rounded-2xl border border-dashed border-border">
                <x-heroicon-o-cube-transparent class="mx-auto h-12 w-12 text-muted-foreground" />
                <h3 class="mt-4 text-lg font-semibold text-foreground">{{ __('messages.no_products_found') }}</h3>
                <p class="mt-2 text-muted-foreground">
                    {{ __('messages.try_adjusting_search') }}
                </p>
                <button
                    wire:click="$set('search', ''); $set('category_id', '')"
                    class="mt-6 text-sm font-medium text-primary hover:underline"
                >
                    Clear all filters
                </button>
            </div>
        @endif
    </div>
</div>
