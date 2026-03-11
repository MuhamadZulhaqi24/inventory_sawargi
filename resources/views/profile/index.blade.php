<x-app-layout :title="__('messages.profile')">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('messages.profile') }}
            </h2>
            <x-secondary-button href="{{ route('dashboard') }}" wire:navigate>
                &larr; {{ __('messages.back_to_dashboard') }}
            </x-secondary-button>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <livewire:profile.edit-profile />

            <livewire:profile.update-password />
        </div>
    </div>
</x-app-layout>
