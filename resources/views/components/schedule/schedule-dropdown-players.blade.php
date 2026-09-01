@props(['table', 'position', 'home'])
@php
    $items = $table->where('position', $position)->where('home', $home);
@endphp

@foreach ($items as $item)
    <label>
        <select wire:change="player({{ $item->id }}, $event.target.value)">
            <option value="0" @selected($item->player === 0)>-- {{ __('select') }} --</option>
            @for ($p = 1; $p <= 4; $p++)
                <option value="{{ $p }}" @selected($item->player === $p)>
                    {{ $home ? __('Home Team') : __('Visit') }} {{ $p }}
                </option>
            @endfor
        </select>
    </label>
@endforeach
