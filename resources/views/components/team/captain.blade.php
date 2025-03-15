@if ($player->captain)
    <x-svg.user-tie-solid color="fill-orange-500" size="6"/>
@else
    <x-svg.circle-user-solid color="fill-green-600" size="6"/>
@endif
