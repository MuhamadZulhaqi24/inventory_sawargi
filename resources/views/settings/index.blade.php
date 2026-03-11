<x-app-layout :title="__('messages.settings')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-foreground leading-tight">
            {{ __('messages.settings') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:settings.setting-table />
        </div>
    </div>

    <livewire:settings.setting-form />
</x-app-layout>
