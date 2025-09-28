<div>
    <x-title title="Participating teams" subtitle="Season {{ $cycle }}" help="teams"/>

    <x-navigation.main-links-buttons/>

    <table class="min-w-full table-auto border-separate border-spacing-y-3">
        <thead class="whitespace-nowrap">
        <tr class="border border-slate-300">
            <th class="border border-slate-300 bg-slate-100 p-2 text-left">
                {{ __('Teams') }}
            </th>
            <th class="hidden border border-slate-300 bg-slate-100 p-2 text-left md:table-cell">
                {{ __('Venue') }}
            </th>
            <th
                class="border border-slate-300 bg-slate-100 p-2 text-center"
                title="number of players"
            >
                <x-svg.list-ul-solid color="fill-blue-700" size="4" padding="mr-2 mb-1"/>
            </th>
            <th class="border border-slate-300 bg-slate-100 p-2 text-left">
                {{ __('Captain') }}
            </th>
            <th class="border border-slate-300 bg-slate-100 p-2 text-left">
                {{ __('Contact') }}
            </th>
        </tr>
        </thead>
        <tbody class="whitespace-nowrap">
        @foreach ($teams as $team)

            <x-team.team-overview-row :team="$team" :my_team="$my_team"/>

        @endforeach
        </tbody>
    </table>
</div>
