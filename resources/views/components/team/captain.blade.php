@if ($player->captain)
    <img alt="" src="{{ secure_asset('svg/user-tie.svg') }}" {{ $attributes->merge(['title' => 'Captain', 'width' => '24px', 'height' => '24px']) }}>
@else
    <img alt="" src="{{ secure_asset('svg/user-circle.svg') }}" {{ $attributes->merge(['title' => 'Player', 'width' => '24px', 'height' => '24px']) }}>
@endif
