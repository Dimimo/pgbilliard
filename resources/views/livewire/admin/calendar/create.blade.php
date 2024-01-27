<div>
    <div class="border border-green-500 bg-green-100 p-4 m-2">
        <x-calendar.explanation :dates="$dates" />
    </div>
    <div class="border border-gray-500 mx-2 my-4">
        <div class="relative flex flex-col">
            <div class="py-3 px-6 mb-4 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                <div class="inline-block text-2xl text-blue-700">
                    Create or update games happening on {{ $last_date->date->format('jS \o\f M Y') }}
                </div>
            </div>

            <div class="flex flex-wrap p-2">
                <div class="w-full lg:w-2/3 pr-4 pl-4">
                    <form wire:submit="save">
                        <div class="border border-indigo-400 border-2 rounded-md p-2 mb-4">
                            <x-calendar.playing-date :dates="$dates" />
                        </div>

                        <div class="flex justify-between w-full border border-green-500 border-2 rounded-md p-2 mb-4">
                            <x-calendar.team-choice teamNr="team1" :teams="$teams">
                                Home Team
                            </x-calendar.team-choice>
                            <x-calendar.team-choice teamNr="team2" :teams="$teams">
                                Visitors
                            </x-calendar.team-choice>
                        </div>

                        <div class="border border-green-500 border-2 rounded-md p-2 mb-4">
                            <x-calendar.venue-choice :venues="$venues">
                                Venue <span class="text-gray-700">(autofilled with Home Team)</span>
                            </x-calendar.venue-choice>
                        </div>

                        <div class="flex justify-between w-full border border-blue-600 border-2 rounded-md p-2 mb-4">
                            <x-calendar.team-score scoreNr="score1">
                                The score of Team 1 <span class="text-gray-700">(optional)</span>
                            </x-calendar.team-score>

                            <x-calendar.team-score scoreNr="score2">
                                The score of Team 2 <span class="text-gray-700">(optional)</span>
                            </x-calendar.team-score>
                        </div>

                        <div class="block">
                            <x-primary-button>Create this game</x-primary-button>

                            <x-spinner target="save"/>
                            <x-action-message class=" inline-block mx-3 text-2xl p-2" on="event-created">
                                Game saved!
                            </x-action-message>

                            <div class="mt-8">
                                <x-secondary-button wire:click="concludeSeason">
                                    The new Season is created
                                </x-secondary-button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="w-full lg:w-1/3 px-4">
                    <x-calendar.events-list :events="$events" :dates="$dates" :last_date="$last_date" />
                </div>
            </div>
        </div>

    </div>
</div>
