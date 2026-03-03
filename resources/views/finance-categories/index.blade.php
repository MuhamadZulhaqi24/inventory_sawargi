<x-app-layout :title="__('messages.finance_categories')">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('messages.finance_categories') }}
            </h2>
            <x-primary-button x-data x-on:click="$dispatch('create-finance-category')">
                <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                {{ __('messages.add_finance_category') }}
            </x-primary-button>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:finance-categories.finance-category-table />
        </div>
    </div>

    <livewire:finance-categories.finance-category-form />
    <livewire:finance-categories.finance-category-detail />
</x-app-layout>
