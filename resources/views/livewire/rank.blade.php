<div>
    @if(session('is_admin'))
        <div class="my-8 flex flex-row items-center space-x-2">
            <button
                type="button"
                class="rounded-lg border border-indigo-700 bg-indigo-100 px-4 py-2"
                wire:click="requestUpdate"
            >
                Request update
            </button>
            <div>
                <x-forms.action-message on="updated">Updated!</x-forms.action-message>
            </div>
        </div>
    @endif

    <table class="my-2 min-w-full bg-transparent table-collapse md:my-4">
        <thead class="whitespace-nowrap">
        <tr>
            <th class="bg-gray-300 p-2 text-center text-gray-900">
                <x-svg.list-ol-solid color="fill-gray-900" size="5"/>
            </th>
            <th class="bg-indigo-100 text-center">
                <x-svg.percent-solid color="fill-indigo-500" size="5"/>
            </th>
            <th class="bg-blue-300 p-2 text-left text-gray-900">Name</th>
            <th class="bg-gray-100 p-2 text-left" title="Current team">
                Current Team
            </th>
            <th class="bg-green-300 p-2 text-center">
                <x-svg.thumbs-up-solid color="fill-green-600" size="5"/>
            </th>
            <th class="bg-red-200 p-2 text-center">
                <x-svg.thumbs-down-solid color="fill-red-600" size="5"/>
            </th>
            <th class="bg-blue-100 p-2 text-center" title="Number of participated games">
                <x-svg.hashtag-solid color="fill-blue-700" size="5"/>
            </th>
            <th class="bg-green-100 p-2 text-center" title="Number of participated playing dates">
                <x-svg.calendar-days-solid color="fill-green-700" size="5"/>
            </th>
        </tr>
        </thead>
        <tbody class="whitespace-nowrap">
        @foreach($results->take(10) as $result)
            <tr class="h-8" wire:key="rank-{{ $result->player->id }}">
                <td class="bg-gray-200 p-2 text-center text-gray-900" title="Your current position">
                    <span class="font-bold">{{ $rank++ }}</span>
                </td>
                <td class="bg-indigo-50 text-center">{{ $result->percentage }}%</td>
                <td class="bg-blue-100 p-2 text-left font-bold">{{ $result->user->name }}</td>
                <td class="bg-gray-50 p-2 text-left">{{ $result->player->team->name }}</td>
                <td class="bg-green-100 text-center">{{ $result->won }}</td>
                <td class="bg-red-100 text-center">{{ $result->lost }}</td>
                <td class="bg-blue-50 text-center">{{ $result->played }}</td>
                <td class="bg-green-50 text-center">{{ $result->participated }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @script
    <script>
        $wire.on('refresh-request', () => {
            $wire.$commit();
        });
    </script>
    @endscript
</div>
