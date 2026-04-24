<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('theme') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-grid { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cpath d='M10 10H90V90H10V10Z' fill='none' stroke='%23e5e7eb' stroke-width='0.5'/%3E%3C/svg%3E"); }
        .dark .bg-grid { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cpath d='M10 10H90V90H10V10Z' fill='none' stroke='%231f2937' stroke-width='0.5'/%3E%3C/svg%3E"); }
    </style>
</head>
<body class="bg-background text-foreground antialiased selection:bg-primary/10">
    <div class="min-h-screen relative flex items-center justify-center p-6 overflow-hidden bg-grid">
        <!-- Decorative blobs -->
        <div class="absolute top-0 -left-4 w-72 h-72 bg-red-100/20 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute -bottom-8 right-20 w-72 h-72 bg-orange-100/10 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

        <div class="relative w-full max-w-lg">
            <div class="bg-card/50 backdrop-blur-md border border-border rounded-2xl shadow-2xl overflow-hidden p-8 sm:p-12 text-center">
                <!-- App Logo/Name -->
                <div class="flex justify-center mb-8">
                    <span class="text-2xl font-black tracking-tighter text-primary font-goldman">{{ config('app.name') }}</span>
                </div>

                <!-- Illustration/Icon -->
                <div class="relative inline-flex mb-8">
                    <div class="absolute inset-0 rounded-full bg-red-500/10 blur-2xl"></div>
                    <div class="relative bg-red-500/10 p-5 rounded-full border border-red-500/20">
                        <x-heroicon-o-lock-closed class="w-12 h-12 text-red-500" />
                    </div>
                </div>

                <!-- Text Content -->
                <div class="space-y-4 mb-10">
                    <h1 class="text-sm font-bold uppercase tracking-[0.2em] text-red-500">Account Restricted</h1>
                    <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl text-foreground">
                        {{ $title }}
                    </h2>
                    <p class="text-muted-foreground text-sm sm:text-base leading-relaxed">
                        {{ $message }}
                    </p>
                </div>

                <!-- Action -->
                <div class="flex flex-col gap-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-primary px-8 py-3 text-sm font-semibold text-primary-foreground shadow-lg shadow-primary/20 transition-all hover:bg-primary/90">
                            Keluar dari Aplikasi
                        </button>
                    </form>
                </div>

                <!-- Footer Info -->
                <div class="mt-10 pt-10 border-t border-border/50 text-[10px] text-muted-foreground uppercase tracking-widest flex items-center justify-center gap-2">
                    <span class="w-1 h-1 rounded-full bg-red-500"></span>
                    SaaS Billing & Protection Active
                    <span class="w-1 h-1 rounded-full bg-red-500"></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
