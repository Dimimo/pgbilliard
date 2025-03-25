<div>
    <ul>
        @foreach($results->take(30) as $result)
            <li>
                <span class="mr-2 font-bold">{{ $rank++ }}</span>{{ $result->percentage }}% - {{ $result->user->name }}
                with {{ $result->won }} games won
                out of {{ $result->played }} total played games
                and {{ $result->lost }} games lost
                with a total participation of {{ $result->participated }} events
            </li>
        @endforeach
    </ul>
</div>
