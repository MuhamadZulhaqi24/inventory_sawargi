<div>
    <x-modal name="customer-detail-modal" focusable>
        @if($customer)
            <div class="p-6">
            <!-- Header -->
            <div class="mb-6 space-y-1.5 text-center sm:text-left border-b border-gray-200 dark:border-border pb-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold leading-none tracking-tight text-foreground">
                        {{ __('messages.customer_details') }}
                    </h3>
                </div>
                <p class="text-sm text-muted-foreground">
                    {{ __('messages.detailed_info_about') }} {{ $customer->name }}.
                </p>
            </div>

            <div class="space-y-6">
                <div class="space-y-1">
                    <label class="text-sm font-medium leading-none text-muted-foreground">{{ __('messages.name') }}</label>
                    <p class="text-sm text-foreground font-medium">{{ $customer->name }}</p>
                </div>

                <!-- Contact Info -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="space-y-1">
                        <label class="text-sm font-medium leading-none text-muted-foreground">{{ __('messages.email') }}</label>
                        <p class="text-sm text-foreground font-medium">{{ $customer->email ?? '-' }}</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium leading-none text-muted-foreground">{{ __('messages.phone') }}</label>
                        <p class="text-sm text-foreground font-medium">{{ $customer->phone ?? '-' }}</p>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-medium leading-none text-muted-foreground">{{ __('messages.address') }}</label>
                    <p class="text-sm text-foreground font-medium">{{ $customer->address ?? '-' }}</p>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-medium leading-none text-muted-foreground">{{ __('messages.notes') }}</label>
                    <p class="text-sm text-foreground font-medium">
                        {{ $customer->notes ?: __('messages.no_notes') }}
                    </p>
                </div>

                <!-- Meta -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="space-y-1">
                        <label class="text-sm font-medium leading-none text-muted-foreground">{{ __('messages.joined_date') }}</label>
                        <p class="text-sm text-foreground font-medium">{{ $customer->created_at?->format('d M Y, H:i') ?? '-' }}</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium leading-none text-muted-foreground">{{ __('messages.last_updated') }}</label>
                        <p class="text-sm text-foreground font-medium">{{ $customer->updated_at?->format('d M Y, H:i') ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex items-center justify-end gap-x-2 pt-4 border-t border-border">
                    <x-secondary-button type="button" x-on:click="$dispatch('close-modal', { name: 'customer-detail-modal' })">
                        {{ __('messages.close') }}
                    </x-secondary-button>

                    <x-primary-button type="button" x-on:click="$dispatch('close-modal', { name: 'customer-detail-modal' }); $dispatch('edit-customer', { customer: {{ $customer->id }} })" class="bg-amber-500 hover:bg-amber-600 focus:ring-amber-500">
                        <x-heroicon-o-pencil-square class="w-4 h-4 mr-2" />
                        {{ __('messages.edit_customer') }}
                    </x-primary-button>
                </div>
            </div>
        @else
            <div class="p-8 text-center flex flex-col items-center justify-center space-y-3">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
                <span class="text-sm text-muted-foreground">{{ __('messages.loading_details') }}</span>
            </div>
        @endif
    </x-modal>
</div>
