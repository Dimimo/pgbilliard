@props(['event'])
{{-- other options: 'short' => false, 'parts' => 2, 'join' => false, --}}

<div class="text-sm text-gray-600">
    {{ __('Available in') }}
    {{ $event->date->date->appTimezone()->midDay()->longAbsoluteDiffForHumans(['syntax' => Carbon\CarbonInterface::DIFF_ABSOLUTE]) }}
</div>
