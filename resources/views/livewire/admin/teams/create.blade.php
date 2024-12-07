<div>
    <x-title title="Create the {{ $number_of_teams }} Teams for Season {{ $season->cycle }}"/>

    <div class="m-2 border border-green-500 bg-green-100 p-4">
        <x-team.explanation :i="$i"/>
    </div>
    @if($teams->count() > 0)
        <div class="m-2 border border-gray-500 p-0">
            <div class="mb-4 flex flex-row items-center bg-blue-100 p-4 text-lg text-blue-900 space-x-2 text-uppercase">
                <div>{{ $i-1 }} of the {{ $number_of_teams }} teams are chosen</div>
                <div class="text-sm text-gray-500">({{ $has_bye ? 'has a BYE' : 'has no BYE' }})</div>
                <x-action-message class="mx-3 text-green-700" on="teams-updated">
                    Saved!
                </x-action-message>
            </div>
            @foreach($teams as $team)
                <livewire:admin.teams.update :team="$team" :key="$team->id"/>
            @endforeach
            <div class="flex justify-between">
                <div class="mt-5 flex w-2/3 justify-start p-4">
                    <x-primary-button wire:click="submit">Update and continue to the Calendar</x-primary-button>
                    <x-spinner target="submit"/>
                    <x-action-message class="mx-3" on="teams-created">
                        Saved!
                    </x-action-message>
                </div>
                @if(!$has_bye)
                    <div class="mt-5 w-1/3 items-center p-4">
                        <x-primary-button wire:click="addBye">
                            Or add a BYE
                        </x-primary-button>
                    </div>
                @endif
            </div>
        </div>
    @endif
    <form class="my-5" wire:submit="save">
        <div class="block">
            <label for="team_select">
                Select team {{ $i++ }}
            </label>
            <select name="team_select" id="team_select" wire:model.change="team_select">
                <option value=""> --- select ---</option>
                @foreach($dropdown_teams as $item)
                    @if(Str::upper($item->name) !== 'BYE')
                        <option value="{{ $item->id }}">{{ $item->season->cycle }} - {{ $item->name }}</option>
                    @endif
                @endforeach
                <option value="0">(Add a new team)</option>
            </select>
        </div>
    </form>
</div>
