<div>
    @if (Route::has('login'))
        <livewire:welcome.navigation/>
    @endif
    <div class="flex flex-wrap mb-4">
        <div class="w-full align-center">
            <img src="{{ secure_asset('images/pg-pool-league.png') }}" width="100%" alt="Pool League logo">

            <livewire:cycle-select/>

            <div class="flex flex-wrap py-2">
                <x-top-nav-link href="{{ route('scoresheet') }}" svg="ordered-list">
                    Results
                </x-top-nav-link>
                <x-top-nav-link href="{{ route('calendar') }}" svg="calendar-date">
                    Calendar
                </x-top-nav-link>
                <x-top-nav-link href="{{ route('teams') }}" svg="team">
                    Teams
                </x-top-nav-link>
            </div>
        </div>
    </div>
</div>
