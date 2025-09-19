<div>
    <x-title
        title="Season Structure"
        subtitle="Create the {{ $number_of_teams }} Teams for Season {{ $season->cycle }}"
    />

    <div class="m-2 border border-green-500 bg-green-100 p-4">
        <x-admin.help.explanation />
    </div>

    @if ($teams->count() > 0)
        <div class="m-2 border border-gray-500 p-0">
            <div class="mb-4 flex justify-between bg-blue-100 p-4">
                <div
                    class="text-uppercase flex flex-row items-center space-x-2 text-lg text-blue-900"
                >
                    <div>{{ $i-1 }} of the {{ $number_of_teams }} teams are chosen</div>
                    <div class="text-sm text-gray-500">
                        ({{ $has_bye ? __('has a BYE') : __('has no BYE') }})
                    </div>
                </div>
                <x-forms.action-message class="mx-3 text-right" on="teams-updated">
                    <div class="text-lg text-green-700">Saved!</div>
                </x-forms.action-message>
            </div>

            @foreach ($teams as $team)
                <livewire:admin.teams.update :team="$team" :key="$team->id" />
            @endforeach

            <div class="flex justify-between">
                <div class="mt-5 flex w-2/3 justify-start p-4">
                    <x-forms.primary-button wire:click="submit">
                        Update and continue to the Calendar
                    </x-forms.primary-button>
                    <x-forms.spinner target="submit" />
                    <x-forms.action-message class="mx-3" on="teams-created">
                        Saved!
                    </x-forms.action-message>
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-row items-center space-x-4">
        <form class="my-5" wire:submit="save">
            <div class="block">
                <label for="team_select">Select team {{ $i++ }}</label>
                <select name="team_select" id="team_select" wire:model.change="team_select">
                    <option value="">--- select ---</option>
                    @foreach ($dropdown_teams as $item)
                        @if (Str::upper($item->name) !== 'BYE')
                            <option value="{{ $item->id }}">
                                {{ $item->season->cycle }} - {{ $item->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </form>

        <div>
            <x-forms.primary-button
                class="!bg-blue-600 hover:!bg-blue-800"
                wire:click="$dispatch('openModal', { component: 'admin.teams.create' })"
            >
                Or create a new team
            </x-forms.primary-button>
        </div>

        @if (!$has_bye)
            <div class="">
                <x-forms.primary-button wire:click="addBye">Or add a BYE</x-forms.primary-button>
            </div>
        @endif

        <div>
            <x-forms.action-message class="mx-3 text-green-700" on="team-added">
                A new team has been added!
            </x-forms.action-message>
        </div>
    </div>
</div>
