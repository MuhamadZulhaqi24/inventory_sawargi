<x-app-layout :title="__('messages.product_list')">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('messages.product_list') }}
            </h2>
            <x-primary-button x-data x-on:click="$dispatch('create-product')">
                <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                {{ __('messages.add_product') }}
            </x-primary-button>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:products.product-table />
        </div>
    </div>

    <livewire:products.product-form />
    <livewire:products.product-detail />
</x-app-layout>
