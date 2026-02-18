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
        <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
        <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-background text-foreground">
        <div class="min-h-screen bg-background flex flex-col">
            <div class="flex-1">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>

            <!-- Footer -->
            @include('layouts.footer')
        </div>
        <x-toaster />
        <livewire:components.delete-modal />
        @livewireScripts
        <script>
            document.addEventListener('livewire:initialized', () => {
                NProgress.configure({ showSpinner: false });

                Livewire.hook('request', ({ respond, succeed, fail }) => {
                    NProgress.start();

                    respond(() => {
                        NProgress.done();
                    });

                    succeed(() => {
                        NProgress.done();
                    });

                    fail(() => {
                        NProgress.done();
                    });
                });

                Livewire.on('open-print-window', (event) => {
                    let url = event.url;
                    if (url) {
                        // Check if current page has 'filters[date_period]' in URL
                        const params = new URLSearchParams(window.location.search);
                        const periodFilter = params.get('filters[date_period]');

                        // If found and not already in target URL, append it
                        if (periodFilter && !url.includes('period=')) {
                            url += (url.includes('?') ? '&' : '?') + 'period=' + periodFilter;
                        }

                        window.open(url, '_blank');
                    }
                });
            });
        </script>

    </body>
</html>
