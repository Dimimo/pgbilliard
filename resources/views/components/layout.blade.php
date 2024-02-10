<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=3.0, user-scalable=yes">
    <meta name="author" content="Dimitri Mostrey (www.puertoparrot.com)">
    <meta name="copyright" content="&copy; &reg; {{ date("Y") }} Puerto Galera Pool League">
    <meta name="description" content="Puerto Galera Pool League">
    <style>
        [x-cloak] {
            display: none !important;
            }
    </style>

    @filamentStyles
    @vite('resources/css/app.css')

    <link rel="stylesheet" href="{{ secure_asset('build/fonts/roboto/roboto.css') }}">

    @stack('css')

    {{--<link rel="apple-touch-icon" sizes="57x57" href="{{ Storage::disk('static')->url('apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ Storage::disk('static')->url('apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ Storage::disk('static')->url('apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ Storage::disk('static')->url('apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ Storage::disk('static')->url('apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ Storage::disk('static')->url('apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ Storage::disk('static')->url('apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ Storage::disk('static')->url('apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ Storage::disk('static')->url('apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
          href="{{ Storage::disk('static')->url('android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ Storage::disk('static')->url('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ Storage::disk('static')->url('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ Storage::disk('static')->url('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">--}}

    <link rel="apple-touch-icon" sizes="57x57" href="{{ secure_asset('apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ secure_asset('apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ secure_asset('apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ secure_asset('apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ secure_asset('apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ secure_asset('apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ secure_asset('apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ secure_asset('apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ secure_asset('android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ secure_asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ secure_asset('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ secure_asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ secure_asset('manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="ui" content="{{ encrypt(Auth::id()) }}">
    <meta name="robots" content="noindex,nofollow">

    <title>Puerto Galera Pool League</title>

</head>

<body>

<div class="container mx-auto sm:px-4">
    <div class="block">
        <livewire:nav-bar />
    </div>
    @if(session('status'))
        <div class="block border-2 border-emerald-700 bg-emerald-100 text-gray-900 p-5 mb-5 text-xl text-center">
            {!! session('status') !!}
        </div>
    @endif
    <div class="block">
        {{ $slot }}
    </div>
    <div class="block">
        <livewire:footer />
    </div>
</div>

@livewire('notifications')

{{-- Begin script --}}
@filamentScripts
@vite('resources/js/app.js')

@stack('js')

<script>
    if (typeof cycle_list === 'undefined')
    {
        const cycle_list =  document.getElementById('cycle_list');
        cycle_list.addEventListener('change', (e) => {
            document.location.href = e.target.value;
        });
    }
</script>
{{-- End script --}}

</body>
</html>
