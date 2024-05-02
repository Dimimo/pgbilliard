<section class="border-2 border-green-500 rounded-md p-4 my-4">
    <div class="my-2 text-center text-xl">
        @isset($title)
            <strong>{!! $title !!}</strong>
        @else
            Plays at <strong>{{ $venue->name }}</strong>
        @endisset
    </div>
    <div class="my-2 text-center text-xl">
        {{ $venue->address }}
    </div>
    <div class="flex justify-center my-2 text-center text-xl">
        <div class="mr-3">
            <img src="{{ secure_asset('svg/user-circle.svg') }}" alt="Contact person" width="24" height="24">
        </div>
        <div>
            {{ $venue->get_contact_name }}
        </div>
    </div>
    <div class="flex justify-center my-2 text-center text-xl">
        <div class="mr-3">
            <img src="{{ secure_asset('svg/mobile-phone.svg') }}" alt="Contact number" width="24" height="24">
        </div>
        <div>
            {{ $venue->get_contact_nr }}
        </div>
    </div>
    @can ('update', $venue)
        <a href="{{ route('venues.edit', ['venue' => $venue]) }}" class="flex justify-end p-4" wire:navigate>
            <div class="mr-2">
                <img src="{{ secure_asset('svg/pen-square.svg') }}" alt="" width="24" height="24">
            </div>
            <div class="text-blue-700">
                Edit this venue
            </div>
        </a>
    @endcan
</section>
