<x-modal name="product-form-modal" :title="''" maxWidth="2xl">
    <div class="p-6 relative">
        <!-- Loading Overlay -->
        <div wire:loading wire:target="create, edit" class="absolute inset-0 z-50 flex items-center justify-center bg-background/50 backdrop-blur-sm rounded-lg">
            <div class="flex flex-col items-center gap-2">
                <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-sm font-medium text-foreground">{{ __('messages.loading_data') }}</span>
            </div>
        </div>

        <!-- Custom Header -->
        <div class="mb-6 space-y-1.5 text-center sm:text-left border-b border-gray-200 dark:border-border pb-4">
            <h3 class="text-lg font-semibold leading-none tracking-tight text-foreground">
                {{ $isEditing ? __('messages.edit_product') : __('messages.add_product') }}
            </h3>
            <p class="text-sm text-muted-foreground">
                {{ $isEditing ? __('messages.edit_product_subtitle') : __('messages.create_product_subtitle') }}
            </p>
        </div>

        <form wire:submit="save" class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- SKU -->
                @if($isEditing)
                    <x-form-input
                        name="sku"
                        :label="__('messages.sku')"
                        type="text"
                        wire:model="sku"
                        readonly
                        placeholder="e.g. SKU-1234-ABCD"
                        class="bg-muted text-muted-foreground cursor-not-allowed"
                    />
                @else
                    <!-- SKU Auto Generated -->
                    <div class="hidden">
                        <input type="hidden" wire:model="sku">
                    </div>
                @endif

                <!-- Name -->
                <x-form-input
                    name="name"
                    :label="__('messages.product_name')"
                    placeholder="e.g. Wireless Mouse"
                    type="text"
                    wire:model="name"
                    required
                    class="{{ !$isEditing ? 'col-span-2' : '' }}"
                />
            </div>

            <!-- Row 2: Category & Unit -->
            <div class="flex flex-col sm:flex-row gap-6">
                <!-- Category -->
                <div class="w-full sm:w-1/2">
                    <x-searchable-select
                        id="category_id"
                        name="category_id"
                        :label="__('messages.category')"
                        wire:model="category_id"
                        :options="$categoryOptions"
                        :placeholder="__('messages.select_category')"
                        required
                    />
                </div>

                <!-- Unit -->
                <div class="w-full sm:w-1/2">
                    <x-searchable-select
                        id="unit_id"
                        name="unit_id"
                        :label="__('messages.unit')"
                        wire:model="unit_id"
                        :options="$unitOptions"
                        :placeholder="__('messages.select_unit')"
                        required
                    />
                </div>
            </div>

            <!-- Prices (Forced Inline) -->
            <div class="flex flex-col sm:flex-row gap-6">
                <!-- Purchase Price -->
                <div class="w-full sm:w-1/2 space-y-2">
                    <x-input-label for="purchase_price" :value="__('messages.purchase_price') . ' (Rp)'" />
                    <x-currency-input
                        id="purchase_price"
                        wire:model.blur="purchase_price"
                        placeholder="0"
                        required
                    />
                    <x-input-error :messages="$errors->get('purchase_price')" />
                </div>

                <!-- Selling Price -->
                <div class="w-full sm:w-1/2 space-y-2">
                    <x-input-label for="selling_price" :value="__('messages.selling_price') . ' (Rp)'" />
                    <x-currency-input
                        id="selling_price"
                        wire:model.blur="selling_price"
                        placeholder="0"
                        required
                    />
                    <x-input-error :messages="$errors->get('selling_price')" />
                </div>
            </div>

            <!-- Row 5: Qty, Min Stock, Active -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Quantity -->
                <x-form-input
                    name="quantity"
                    :label="__('messages.qty')"
                    type="number"
                    wire:model="quantity"
                    min="0"
                    placeholder="0"
                    required
                />

                <!-- Min Stock -->
                <x-form-input
                    name="min_stock"
                    :label="__('messages.min_stock')"
                    type="number"
                    wire:model="min_stock"
                    min="0"
                    placeholder="0"
                    required
                />

                <!-- Is Active -->
                <div class="flex items-center h-full pt-8">
                    <label class="inline-flex items-center cursor-pointer">
                        <input
                            type="checkbox"
                            wire:model="is_active"
                            class="w-6 h-6 rounded-full border-2 border-primary text-primary focus:ring-primary/20"
                        >
                        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.active') }}
                        </span>
                    </label>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <x-input-label for="description" :value="__('messages.description')" />
                <textarea
                    id="description"
                    wire:model="description"
                    rows="3"
                    class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    placeholder="{{ __('messages.optional_description') }}"
                ></textarea>
                <x-input-error :messages="$errors->get('description')" />
            </div>

            <!-- Notes -->
            <div class="space-y-2">
                <x-input-label for="notes" :value="__('messages.internal_notes')" />
                <textarea
                    id="notes"
                    wire:model="notes"
                    rows="3"
                    class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    placeholder="{{ __('messages.pricing_history_placeholder') }}"
                ></textarea>
                <x-input-error :messages="$errors->get('notes')" />
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-end gap-3 border-t pt-4 border-gray-200">
                <x-secondary-button type="button" x-on:click="$dispatch('close-modal', { name: 'product-form-modal' })">
                    {{ __('messages.back') }}
                </x-secondary-button>

                <x-primary-button type="submit" wire:loading.attr="disabled">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <x-heroicon-o-check wire:loading.remove wire:target="save" class="w-4 h-4 mr-2" />
                    {{ $isEditing ? __('messages.save_changes') : __('messages.add_product') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
