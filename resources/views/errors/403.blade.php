<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('theme') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-foreground antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center p-6 text-center">
        <!-- Icon -->
        <div class="mb-6 inline-flex items-center justify-center w-24 h-24 rounded-full bg-orange-100 dark:bg-orange-900/20">
            <x-heroicon-o-shield-exclamation class="w-12 h-12 text-orange-600 dark:text-orange-400" />
        <title>{{ __('messages.error_403_title') }}</title>
        ...
            <!-- Text -->
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl mb-4">403</h1>
            <h2 class="text-2xl font-bold mb-2">{{ __('messages.error_403_title') }}</h2>
            <p class="text-muted-foreground max-w-md mb-8">
                {{ __('messages.error_403_msg') }}
            </p>

            <!-- Action -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground shadow hover:bg-primary/90 h-10 px-8">
                    {{ __('messages.back_to_dashboard') }}
                </a>
                <button onclick="window.history.back()" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground h-10 px-8">
                    {{ __('messages.previous_page') }}
                </button>
            </div>

        <!-- Quote/Footer -->
        <div class="mt-12 text-xs text-muted-foreground uppercase tracking-widest">
            {{ config('app.name') }} Security System
        </div>
    </div>
</body>
</html>
