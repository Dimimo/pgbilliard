@props(['event'])

<div class="text-sm text-gray-600">
    Starts in {{ $event->date->date->appTimezone()->midDay()->addHours(2)->diffForHumans(['short' => false, 'parts' => 2, 'join' => true]) }}
</div>
