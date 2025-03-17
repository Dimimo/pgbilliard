@props(['event'])

<div class="text-sm text-gray-600">
    {{__('Available in')}} {{ $event->date->date->appTimezone()->midDay()->addHour()->diffForHumans(['short' => false, 'parts' => 2, 'join' => true]) }}
</div>
