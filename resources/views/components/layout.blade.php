<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=3.0, user-scalable=yes">
    <meta name="author" content="Dimitri Mostrey (www.pgbilliard.com)">
    <meta name="copyright" content="&copy; &reg; {{ date("Y") }} Puerto Galera Pool League">
    <meta name="description" content="Puerto Galera Pool League">

    @vite('resources/css/app.css')

    <link rel="stylesheet" href="{{ secure_asset('webfonts/roboto/roboto.css') }}">

    @stack('css')

    <link rel="apple-touch-icon" sizes="57x57" href="{{ secure_asset('apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ secure_asset('apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ secure_asset('apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ secure_asset('apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ secure_asset('apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ secure_asset('apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ secure_asset('apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ secure_asset('apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ secure_asset('android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ secure_asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ secure_asset('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ secure_asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ secure_asset('manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow">

    <title>Puerto Galera Pool League</title>

</head>

<body class="flex min-h-screen flex-col font-sans antialiased">
<header class="sticky top-0 z-10 block h-20 bg-white">
    <livewire:layout.navigation/>
</header>

<main class="container relative mx-auto grow sm:px-4 md:px-8 lg:px-20">

    @if(session('status'))
        <div class="mb-5 block border-2 border-emerald-700 bg-emerald-100 p-5 text-center text-xl text-gray-900">
            {!! session('status') !!}
        </div>
    @endif

    @if(auth()->user()?->isAdmin())
        <div class="my-5 border border-slate-300 bg-slate-100 p-4 sm:hidden">
            <span class="font-bold">Note to the admins:</span> if you see this message, the screen of your device is too small.
            You need a <span class="text-lg">bigger screen</span> to work in the ADMIN section. It is generally not designed for small devices.
        </div>
    @endif

    <div class="block">
        {{ $slot }}
    </div>

    @if(request()->routeIs(['index', 'scoresheet', 'calendar', 'teams.index']))
        <livewire:cycle-select/>
    @endif

</main>

<footer class="block">
    <livewire:footer/>
</footer>

{{-- Begin script --}}
@vite('resources/js/app.js')

@stack('js')
{{-- End script --}}

@livewire('wire-elements-modal')
</body>
</html>
