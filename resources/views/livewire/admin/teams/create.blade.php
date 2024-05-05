<div>
    <x-title title="Create the {{ $number_of_teams }} Teams for Season {{ $season->cycle }}"/>

    <div class="border border-green-500 bg-green-100 p-4 m-2">
        <x-team.explanation :i="$i"/>
    </div>
    @if($teams)
        <div class="border border-gray-500 p-0 m-2">
            <div class="text-blue-900 text-lg text-uppercase bg-blue-100 mb-4 p-4">
                {{ $i-1 }} of the {{ $number_of_teams }} teams are chosen
                <span class="text-gray-500 text-[15px]">({{ $has_bye ? 'has a BYE' : 'has no BYE' }})</span>
            </div>
            @foreach($teams as $key => $team)
                <div class="w-full block content-center my-2 pl-2" wire:key="{{ $team->id }}">
                    <input type="hidden" name="team_{{ $key }}_id" value="{{ $team->id }}" wile:model.defer="teams.{{$key}}.id">

                    <label for="team_{{$key}}_name" class="inline-block mr-2">The team</label>
                    <input type="text" id="team_{{$key}}_name" wire:model.defer="teams.{{$key}}.name"
                           class="shadow-sm border-1 border-blue-300 focus:outline-none p-3 inline-block sm:text-sm rounded-md" placeholder="{{ $team->name }}">
                    @error('teams.'.$key.'.name') <span class="text-xs text-red-600">{{ $message }}</span> @enderror

                    <label for="team_{{$key}}_venue_id" class="inline-block mx-2">
                        Plays at
                    </label>
                    <select class="inline-block" id="team_{{$key}}_venue_id" wire:model.defer="teams.{{ $key }}.venue_id">
                        <option>Select venue...</option>
                        @foreach($venues as $venue)
                            <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                        @endforeach
                    </select>
                    <div class="inline-block">
                        @error('teams.'.$key.'.venue_id') <span class="text-red-700">{{ $message }}</span> @enderror
                    </div>

                    <label for="team_{{$key}}_user_id" class="inline-block mx-2">
                        Captain
                    </label>
                    <select class="inline-block" id="team_{{$key}}_user_id" wire:model.change="teams.{{ $key }}.user_id">
                        <option>Select captain...</option>
                        @foreach($users as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>

                    @if(!$team->hasGames())
                        <div class="inline-block ml-2 mt-2">
                            <button
                                type="button"
                                title="Remove this team"
                                wire:click="removeTeam({{ $key }})"
                                wire:confirm="Do you want to remove this team?\nYou cqn always add again later."
                            >
                                <img class="mx-auto" src="{{ secure_asset('svg/minus-box-fill.svg') }}" alt="Remove" width="24" height="24">
                            </button>
                        </div>
                    @endif
                    <div>
                        @error('teams.'.$key.'.user_id') <span class="text-red-700">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endforeach
            <div class="flex justify-between">
                <div class="w-2/3 flex justify-start mt-5 p-4">
                    <x-primary-button wire:click="submit">Update and continue to the Calendar</x-primary-button>
                    <x-spinner target="submit"/>
                    <x-action-message class="mx-3" on="teams-created">
                        Saved!
                    </x-action-message>
                </div>
                @if(!$has_bye)
                    <div class="w-1/3 items-center mt-5 p-4 ">
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
            <label for="team_id">
                Select team {{ $i++ }}
            </label>
            <select name="team_id" id="team_id" wire:model.change="team_id">
                <option> --- select ---</option>
                @foreach($dropdown_teams as $item)
                    <option value="{{ $item->id }}">{{ $item->season->cycle }} - {{ $item->name }}</option>
                @endforeach
                <option value="0">(Add a new team)</option>
            </select>
        </div>
    </form>
</div>
