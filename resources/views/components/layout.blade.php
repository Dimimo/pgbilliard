<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, minimum-scale=0.1, maximum-scale=3.0, user-scalable=yes"
        />
        <meta name="author" content="Dimitri Mostrey (www.pgbilliard.com)" />
        <meta
            name="copyright"
            content="&copy; &reg; {{ date("Y") }} Puerto Galera Billiard League"
        />
        <meta name="description" content="Puerto Galera Pool League" />

        <link
            rel="preload"
            href="{{ secure_asset('webfonts/roboto/roboto.css') }}"
            onload="this.onload=null;this.rel='stylesheet';this.removeAttribute('as')"
            as="style"
        />

        @vite('resources/css/app.css')
        @stack('css')
        @PwaHead

        <link
            rel="apple-touch-icon"
            sizes="180x180"
            href="{{ secure_asset('apple-icon-180x180.png') }}"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="192x192"
            href="{{ secure_asset('android-icon-192x192.png') }}"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="96x96"
            href="{{ secure_asset('favicon-96x96.png') }}"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="32x32"
            href="{{ secure_asset('favicon-32x32.png') }}"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="{{ secure_asset('favicon-16x16.png') }}"
        />
        <meta name="msapplication-TileColor" content="#ffffff" />
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="robots" content="noindex,nofollow" />

        <title>{{ isset($title) ? $title . ' | ' : '' }}Puerto Galera Pool League</title>
    </head>

    <body class="flex min-h-screen flex-col font-sans antialiased">
        <header class="sticky top-0 z-10 block h-20 bg-white">
            <livewire:layout.navigation />
        </header>

        <section id="session-alerts" class="relative mx-auto mt-4 flex justify-center">
            @if (session()->hasAny(['status', 'success', 'warning', 'error', 'info']))
                <x-alerts />
            @endif
        </section>

        <main class="container relative mx-auto grow sm:px-4 md:px-8 lg:px-20">
            @if (session('is_admin'))
                <div class="my-5 border border-slate-300 bg-slate-100 p-4 sm:hidden">
                    <span class="font-bold">Note to the admins:</span>
                    if you see this message, the screen of your device is too small. You need a
                    <span class="text-lg">bigger screen</span>
                    to work in the ADMIN section. It is generally not designed for small devices.
                </div>
            @endif

            <div class="block">
                {{ $slot }}
            </div>

            @if (request()->routeIs(['index', 'scoreboard', 'calendar', 'teams.index', 'dashboard']))
                <livewire:cycle-select />
            @endif
        </main>

        <footer class="block">
            <livewire:footer />
        </footer>

        {{-- Begin script --}}
        @vite(['resources/js/app.js', 'resources/js/ably.js'])
        @stack('js')
        @livewire('wire-elements-modal')
        <x-toaster-hub />
        @RegisterServiceWorkerScript
        {{-- End script --}}
    </body>
</html>
