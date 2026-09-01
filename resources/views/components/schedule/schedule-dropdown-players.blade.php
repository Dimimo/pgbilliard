@props(['table', 'position', 'home', 'players'])
@php
    $items = $table->where('position', $position)->where('home', $home);
@endphp

@if ($position === 15 && $players !== 3)
    <span class="text-sm italic text-gray-600">{{ __('Selected on game day') }}</span>
@else
    @foreach ($items as $item)
        <label>
            <select wire:change="player({{ $item->id }}, $event.target.value)">
                <option value="0" @selected($item->player === 0)>-- {{ __('select') }} --</option>
                @for ($p = 1; $p <= $players; $p++)
                    <option value="{{ $p }}" @selected($item->player === $p)>
                        {{ $home ? __('Home Team') : __('Visit') }} {{ $p }}
                    </option>
                @endfor
            </select>
        </label>
    @endforeach
@endif
