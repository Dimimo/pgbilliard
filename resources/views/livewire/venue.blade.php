<div>
    <div class="my-2 text-center text-xl">
        Plays at <strong>{{ $venue->name }}</strong>
    </div>
    <div class="my-2 text-center text-xl">
        {{ $venue->address }}
    </div>
    <div class="flex justify-center my-2 text-center text-xl">
        <div class="mr-3">
            <img src="{{ secure_asset('svg/user-circle.svg') }}" alt="Contact person" width="24" height="24">
        </div>
        <div>
            {{ $venue->contact_name }}
        </div>
    </div>
    <div class="flex justify-center my-2 text-center text-xl">
        <div class="mr-3">
            <img src="{{ secure_asset('svg/mobile-phone.svg') }}" alt="Contact number" width="24" height="24">
        </div>
        <div>
            {{ $venue->contact_nr }}
        </div>
    </div>
</div>
