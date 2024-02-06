<x-layout>
    @yield('data')

    @include('laravel-forum::'.config('laravel-forum.views.folder').'shared.scripts.avatar')
    @include('laravel-forum::'.config('laravel-forum.views.folder').'shared.scripts.input-boolean')
</x-layout>
