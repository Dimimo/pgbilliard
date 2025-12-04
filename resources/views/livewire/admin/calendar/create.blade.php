@if (str_contains(URL::current(), 'season/update'))
    @php
        $new = false;
    @endphp
@else
    @php
        $new = true;
    @endphp
@endif
<div>
    <div class="m-2 rounded-lg border border-green-500 bg-green-100 p-4">
        <x-admin.help.calendar :dates="$dates" :new="$new" />
    </div>
    <div class="mx-2 my-4 rounded-lg border border-blue-600">
        <div class="relative flex flex-col">
            <div
                class="mb-4 rounded-t-lg border-b border-blue-600 bg-blue-100 px-6 py-3 text-gray-900"
            >
                <div class="inline-block text-2xl text-blue-700">
                    Create or update games happening on the
                    {{ $last_date->date->format('jS \o\f M Y') }}
                </div>
            </div>

            <div class="flex flex-wrap p-2">
                <div class="w-full px-4 lg:w-2/3">
                    <form wire:submit="save">
                        <div class="mb-4 rounded-md border-2 border-indigo-400 p-2">
                            <x-calendar.playing-date :dates="$dates" :last_day="$last_date" />
                        </div>

                        <div
                            class="mb-4 flex w-full justify-between rounded-md border-2 border-green-500 p-2"
                        >
                            <x-calendar.team-choice teamNr="team1" :teams="$teams">
                                Home Team
                            </x-calendar.team-choice>
                            <x-calendar.team-choice teamNr="team2" :teams="$teams">
                                Visitors
                            </x-calendar.team-choice>
                        </div>

                        <div class="mb-4 rounded-md border-2 border-green-500 p-2">
                            <x-calendar.venue-choice :venues="$venues">
                                Venue
                            </x-calendar.venue-choice>
                        </div>

                        <div class="block">
                            <x-forms.primary-button wire:loading.attr="disabled">
                                Create this game
                            </x-forms.primary-button>

                            <x-forms.spinner target="save, form.team1, form.team2, form.venue_id" />
                            <x-forms.action-message
                                class="mx-3 inline-block p-2 text-2xl text-green-700"
                                on="event-created"
                            >
                                Game saved!
                            </x-forms.action-message>
                            <x-forms.action-message
                                class="mx-3 inline-block p-2 text-2xl text-green-700"
                                on="team-added"
                            >
                                The new team has been added!
                            </x-forms.action-message>

                            <div class="mt-8">
                                <x-forms.primary-button
                                    class="bg-blue-600! hover:bg-blue-800!"
                                    wire:click="$dispatch('openModal', { component: 'admin.teams.create' })"
                                >
                                    You may create a new team here
                                </x-forms.primary-button>
                            </div>

                            @if ($new === true)
                                <div class="mt-8">
                                    <x-forms.secondary-button
                                        class="bg-green-100!"
                                        wire:click="concludeSeason"
                                    >
                                        When the new Calendar is finished, check the results
                                    </x-forms.secondary-button>
                                </div>
                            @else
                                <div class="mt-8">
                                    <x-forms.secondary-button wire:click="continueToCalendar">
                                        When done, you may continue to the Calendar overview
                                    </x-forms.secondary-button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="w-full px-4 lg:w-1/3">
                    <x-forms.spinner target="form.date_id" />
                    <div wire:target="form.date_id" wire:loading.remove>
                        <x-calendar.events-list
                            :events="$events"
                            :dates="$dates"
                            :last_date="$last_date"
                            :key="Str::random(8)"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
