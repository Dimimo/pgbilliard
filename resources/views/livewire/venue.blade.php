<section class="my-4 rounded-md border-2 border-green-500">
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
    <div class="my-2 flex justify-center text-center text-xl">
        <div class="mr-3">
            <x-svg.circle-user-solid color="fill-green-600" size="6"/>
        </div>
        <div>
            {{ $venue->get_contact_name }}
        </div>
    </div>
    <div class="my-2 flex justify-center text-center text-xl">
        <div class="mr-3">
            <x-svg.mobile-screen-solid color="fill-green-600" size="6"/>
        </div>
        <div>
            @auth()
                {{ $venue->get_contact_nr }}
            @else
                hidden
            @endauth
        </div>
    </div>
    @can ('update', $venue)
        <div class="mr-4 mb-1 flex justify-end">
            <a href="{{ route('venues.edit', ['venue' => $venue]) }}" class="inline-block link" wire:navigate>
                <div class="text-blue-700">
                    <x-svg.pen-to-square-solid color="fill-blue-700" size="4" padding="mr-2 mb-1"/>
                    Edit this venue
                </div>
            </a>
        </div>
    @endcan
</section>
