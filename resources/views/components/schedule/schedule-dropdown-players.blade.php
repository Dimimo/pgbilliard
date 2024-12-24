@props(['table', 'position', 'home'])
@php
    $items = $table->where('position', $position)->where('home', $home);
    $double_count = $position % 5 === 0 ? 2 : 1;
@endphp

@if ($items->count() === 0)
    {{-- ensure it rolls out twice if it's a double --}}
    @for($c=1;$c<=$double_count;$c++)
        <label>
            <select>
                <option
                    x-on:click="$wire.player(0, {{ $position }}, {{ $home }})"
                >
                    -- select --
                </option>
                @for($p=1;$p<=4;$p++)
                    <option
                        x-on:click="$wire.player({{ $p }}, {{ $position }}, {{ $home }})"
                    >
                        {{ $home ? 'Home' : 'Visit' }} {{ $p }}
                    </option>
                @endfor
            </select>
        </label>
    @endfor
@else
    @foreach($items as $item)
        <label>
            <select>
                <option
                    x-on:click="$wire.player(0, {{ $position }}, {{ $home }})"
                >
                    -- select --
                </option>
                @for($p=1;$p<=4;$p++)
                    <option
                        @selected($item->player === $p)
                        x-on:click="$wire.player({{ $p }}, {{ $position }}, {{ $home }})"
                    >
                        {{ $home ? 'Home' : 'Visit' }} {{ $p }}
                    </option>
                @endfor
            </select>
        </label>
    @endforeach
@endif

