<x-app-layout :title="'Daftar ' . t_label('product')">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                Daftar {{ t_label('product') }}
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
