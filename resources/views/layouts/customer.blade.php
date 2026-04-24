@props(['title' => ''])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}{{ !empty($title) ? ' | ' . $title : '' }}</title>

        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-background text-foreground">
        <div class="min-h-screen bg-background flex flex-col">
            <!-- Customer Header -->
            <header class="py-4 {{ request()->routeIs('home') ? 'bg-gray-100 dark:bg-background' : 'bg-background' }} border-b border-border sticky top-0 z-40 backdrop-blur-sm {{ request()->routeIs('home') ? 'bg-gray-100/80 dark:bg-background/80' : 'bg-background/80' }}" x-data="{ mobileMenuOpen: false }">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <!-- Logo -->
                        <a href="{{ route('home') }}" class="flex items-center gap-2">
                            <x-application-logo class="w-8 h-8 fill-current text-foreground" />
                            <span class="text-xl font-black tracking-tighter text-foreground font-goldman">
                                {{ \App\Models\Setting::get('store_name', config('app.name')) }}
                            </span>
                        </a>

                        <!-- Desktop Navigation -->
                        <nav class="hidden md:flex items-center gap-8">
                            <a href="{{ route('home') }}" class="text-sm font-bold {{ request()->routeIs('home') ? 'text-primary' : 'text-muted-foreground hover:text-foreground' }} transition-colors uppercase tracking-widest">{{ __('messages.home') }}</a>
                            <a href="{{ route('catalog') }}" class="text-sm font-bold {{ request()->routeIs('catalog') ? 'text-primary' : 'text-muted-foreground hover:text-foreground' }} transition-colors uppercase tracking-widest">{{ __('messages.catalog') }}</a>
                            <a href="{{ route('about') }}" class="text-sm font-bold {{ request()->routeIs('about') ? 'text-primary' : 'text-muted-foreground hover:text-foreground' }} transition-colors uppercase tracking-widest">{{ __('messages.about') }}</a>
                            <a href="{{ route('contact') }}" class="text-sm font-bold {{ request()->routeIs('contact') ? 'text-primary' : 'text-muted-foreground hover:text-foreground' }} transition-colors uppercase tracking-widest">{{ __('messages.contact') }}</a>
                        </nav>

                        <div class="flex items-center gap-4">
                             <!-- Language Switcher -->
                             <div class="flex items-center">
                                @if(app()->getLocale() == 'en')
                                    <a href="{{ route('language.switch', 'id') }}" class="text-xs font-bold px-2 py-1 rounded-md hover:bg-muted text-muted-foreground flex items-center gap-1">
                                        <span class="text-foreground">EN</span>
                                        <span class="opacity-50">ID</span>
                                    </a>
                                @else
                                    <a href="{{ route('language.switch', 'en') }}" class="text-xs font-bold px-2 py-1 rounded-md hover:bg-muted text-muted-foreground flex items-center gap-1">
                                        <span class="opacity-50">EN</span>
                                        <span class="text-foreground">ID</span>
                                    </a>
                                @endif
                            </div>

                            <button
                                x-data="{
                                    theme: localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),
                                    toggleTheme() {
                                        this.theme = this.theme === 'dark' ? 'light' : 'dark';
                                        localStorage.setItem('theme', this.theme);
                                        if (this.theme === 'dark') {
                                            document.documentElement.classList.add('dark');
                                        } else {
                                            document.documentElement.classList.remove('dark');
                                        }
                                    }
                                }"
                                @click="toggleTheme()"
                                class="rounded-md p-2 text-muted-foreground hover:bg-muted hover:text-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                            >
                                <x-heroicon-o-sun x-show="theme === 'dark'" class="h-5 w-5" style="display: none;" />
                                <x-heroicon-o-moon x-show="theme === 'light'" class="h-5 w-5" />
                            </button>

                            <div class="hidden md:block">
                                @auth
                                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-md text-primary-foreground bg-primary hover:bg-primary/90 transition-all uppercase tracking-widest">
                                        {{ __('messages.dashboard') }}
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm font-bold text-muted-foreground hover:text-foreground uppercase tracking-widest">
                                        {{ __('Login') }}
                                    </a>
                                @endauth
                            </div>

                            <!-- Mobile menu button -->
                            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-md text-muted-foreground hover:bg-muted">
                                <x-heroicon-o-bars-3 x-show="!mobileMenuOpen" class="h-6 w-6" />
                                <x-heroicon-o-x-mark x-show="mobileMenuOpen" class="h-6 w-6" style="display: none;" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <div x-show="mobileMenuOpen" x-collapse class="md:hidden border-t border-border bg-card">
                    <div class="px-4 pt-2 pb-6 space-y-1">
                        <a href="{{ route('home') }}" class="block px-3 py-4 text-base font-bold text-foreground border-b border-border/50">{{ __('messages.home') }}</a>
                        <a href="{{ route('catalog') }}" class="block px-3 py-4 text-base font-bold text-foreground border-b border-border/50">{{ __('messages.catalog') }}</a>
                        <a href="{{ route('about') }}" class="block px-3 py-4 text-base font-bold text-foreground border-b border-border/50">{{ __('messages.about') }}</a>
                        <a href="{{ route('contact') }}" class="block px-3 py-4 text-base font-bold text-foreground border-b border-border/50">{{ __('messages.contact') }}</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="block px-3 py-4 text-base font-bold text-primary">{{ __('messages.dashboard') }}</a>
                        @else
                            <a href="{{ route('login') }}" class="block px-3 py-4 text-base font-bold text-muted-foreground">{{ __('Login') }}</a>
                        @endauth
                    </div>
                </div>
            </header>

            <div class="flex-1">
                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>

            <!-- Footer -->
            <footer class="py-16 border-t border-border bg-gray-100 dark:bg-muted/30 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                        <!-- Store Identity -->
                        <div class="space-y-6 lg:col-span-1">
                            <div class="flex items-center gap-2">
                                <x-application-logo class="w-8 h-8 fill-current text-foreground" />
                                <span class="text-xl font-black tracking-tighter font-goldman">{{ \App\Models\Setting::get('store_name', config('app.name')) }}</span>
                            </div>
                            <p class="text-sm text-muted-foreground leading-relaxed">
                                {{ __('Menyediakan bahan bangunan berkualitas tinggi dengan harga yang jujur, memberikan kemudahan dalam mencari bahan bangunan yang Anda butuhkan.') }}
                            </p>
                        </div>

                        <!-- Contact Information -->
                        <div class="space-y-6">
                            <h4 class="text-xs font-black uppercase tracking-[0.2em] text-foreground/50">{{ __('Kontak Kami') }}</h4>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3 text-sm text-muted-foreground">
                                    <x-heroicon-o-map-pin class="w-5 h-5 text-primary shrink-0" />
                                    <span>{{ \App\Models\Setting::get('store_address', 'Jl. Koperasi No.1B, Kertasari, Kec. Ciamis, Kabupaten Ciamis, Jawa Barat 46213') }}</span>
                                </li>
                                <li class="flex items-center gap-3 text-sm text-muted-foreground">
                                    <x-heroicon-o-phone class="w-5 h-5 text-primary shrink-0" />
                                    <span>{{ \App\Models\Setting::get('store_phone', '0265426243') }}</span>
                                </li>
                                <li class="flex items-center gap-3 text-sm text-muted-foreground">
                                    <x-heroicon-o-envelope class="w-5 h-5 text-primary shrink-0" />
                                    <span>{{ __('sawargijaya@gmail.com') }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Hours -->
                        <div class="space-y-6">
                            <h4 class="text-xs font-black uppercase tracking-[0.2em] text-foreground/50">{{ __('Jam Operasional') }}</h4>
                            <ul class="space-y-3 text-sm text-muted-foreground">
                                <li class="flex justify-between">
                                    <span>Senin - Sabtu:</span>
                                    <span class="font-bold text-foreground">08:00 - 17:00</span>
                                </li>
                                <li class="flex justify-between">
                                    <span>Minggu:</span>
                                    <span class="font-bold text-destructive">Tutup</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-16 pt-8 border-t border-border flex flex-col md:flex-row justify-between items-center gap-6">
                        <p class="text-xs font-medium text-muted-foreground italic">
                            &copy; {{ date('Y') }} {{ \App\Models\Setting::get('store_name', config('app.name')) }}. All rights reserved.
                        </p>
                        <div class="flex gap-6">
                            <a href="#" class="text-muted-foreground hover:text-primary transition-all hover:scale-110">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                            </a>
                            <a href="#" class="text-muted-foreground hover:text-primary transition-all hover:scale-110">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zM12 7.004a4.996 4.996 0 100 9.992 4.996 4.996 0 000-9.992zm0 8.188a3.196 3.196 0 110-6.392 3.196 3.196 0 010 6.392zm5.23-8.621a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        @livewireScripts
    </body>
</html>
