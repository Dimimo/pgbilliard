<div>
    <table class="table-auto">
        <thead>
        <tr>
            <th>Home Team</th>
            <th>Visitors</th>
            <th>Score</th>
            <th>Venue</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($date->events as $event)
            <tr>
                <td>{{ $event->team_1->name }}</td>
                <td>{{ $event->team_2->name }}</td>
                <td>{{ $event->score1 }} - {{ $event->score2 }}</td>
                <td>{{ $event->venue->name }}</td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
