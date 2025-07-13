<div class="mt-12 rounded-lg border-2 border-gray-900 p-4">
    <x-title
        title="{{__('The individual ranking overview')}}"
        subtitle="{{__('Season')}} {{ session('cycle') }}"
        help="ranking"
        :gradient="false"
    />

    <div class="m-auto mb-4 rounded-lg border border-indigo-400 bg-indigo-50 p-2 text-center">
        <div class="mb-4 font-bold">
            This is still experimental! Please read the help file
            <button wire:click="$dispatch('openModal', { component: 'help.ranking' })">
                <x-svg.circle-question-regular color="fill-green-700" size="4"/>
            </button>
        </div>
        <div class="mb-4">
            Some things to consider.
        </div>
        <div class="mb-4">At first the list shows <span class="font-bold">the {{ $median }} best players</span>
            of a total of {{ $results->count() }} players in this Season.
        </div>
        <div class="mb-4">
            How and why?<br>
            The number is the median of the total games played
            (<span class="text-lg font-bold text-blue-700">#</span> in the list)
        </div>
        <div class="mb-4">
            Optionally, you can see the list of all players.<br>
            Either way, the calculation of the percentage is strait forward:<br>
            <span class="font-mono">(Games Won / Total Games) * 100</span>
        </div>
        <div class="mb-4">
            {{__('New') }}: {{__('click on a name to see the game details')}}
        </div>
        @if(session('is_admin'))
            <div class="text-center">
                <button
                    type="button"
                    class="rounded-lg border border-gray-600 bg-gray-50 px-4 py-2 text-gray-700"
                    wire:click="requestUpdate"
                >
                    Request update <span class="italic">(only for admins)</span>
                </button>
                <x-forms.action-message on="updated">{{__('Updated')}}!</x-forms.action-message>
            </div>
        @endif
    </div>

    <div class="flex justify-center">
        <x-forms.primary-button wire:click="toggleMedian">
            @if ($show_all_results)
                Show only the {{ $median }} best players (median #)
            @else
                Show the list of ALL players (not accurate)
            @endif
        </x-forms.primary-button>
    </div>

    <table class="my-2 min-w-full bg-transparent table-collapse md:my-4">
        <thead class="whitespace-nowrap">
        <tr>
            <th class="bg-gray-300 p-2 text-center text-gray-900">
                <x-svg.list-ol-solid color="fill-gray-900" size="5"/>
            </th>
            <th class="bg-indigo-100 text-center">
                <x-svg.percent-solid color="fill-indigo-500" size="5"/>
            </th>
            <th class="bg-blue-300 p-2 text-left text-gray-900">{{__('Name')}}</th>
            <th class="bg-gray-100 p-2 text-left" title="{{__('Current team')}}">
                {{__('Current Team')}}
            </th>
            <th class="bg-green-300 p-2 text-center">
                <x-svg.thumbs-up-solid color="fill-green-600" size="5"/>
            </th>
            <th class="bg-red-200 p-2 text-center">
                <x-svg.thumbs-down-solid color="fill-red-600" size="5"/>
            </th>
            <th class="bg-blue-100 p-2 text-center" title="{{__('Number of games participated')}}">
                <x-svg.hashtag-solid color="fill-blue-700" size="5"/>
            </th>
            <th class="bg-green-100 p-2 text-center" title="{{__('Number of participated playing dates')}}">
                <x-svg.calendar-days-solid color="fill-green-700" size="5"/>
            </th>
        </tr>
        </thead>
        <tbody class="whitespace-nowrap">
        @foreach($results->sortByDesc('played')->take($count)->sortByDesc('percentage') as $result)
            <tr class="h-8" wire:key="rank-{{ $result->player->id }}">
                <td class="bg-gray-200 p-2 text-center text-gray-900" title="{{__('Your current position')}}">
                    <span class="font-bold">{{ $rank++ }}</span>
                </td>
                <td class="bg-indigo-50 text-center">{{ $result->percentage }}%</td>
                <td class="bg-blue-100 p-2 text-left font-bold">
                    <a class="link" href="{{ route('player.show', ['player' => $result->player->id]) }}" wire:navigate>
                        {{ $result->user->name }}
                    </a>
                </td>
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
