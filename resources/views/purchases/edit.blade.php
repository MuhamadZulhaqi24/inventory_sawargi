<x-app-layout :title="__('messages.edit_purchase')">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('messages.edit_purchase') }} #{{ $purchase->id }}
            </h2>
            <x-secondary-button href="{{ route('purchases.index') }}">
                &larr; {{ __('messages.back_to_list') }}
            </x-secondary-button>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:purchases.purchase-form :purchase="$purchase" />
        </div>
    </div>
</x-app-layout>
