<div class="grid justify-items-center">
    <div>
        <table class="min-w-full md:min-w-0 mb-4 table-collapse bg-transparent border border-gray-900 border-2">
            <thead class="whitespace-nowrap bg-gray-300 border border-2 border-gray-900">
            <tr class="py-2">
                <th class="p-2 text-left">Home</th>
                <th class="p-2 text-left">Visitors</th>
                <th class="p-2 text-center" colspan="2">
                    <div class="flex items-center">
                        <div class="inline-block">Scores</div>
                        <div class="inline-block -mb-1">
                            <x-spinner/>
                        </div>
                        <div class="inline-block ml-2">
                            <x-action-message class="text-green-700 font-semibold" on="scores-updated">
                                Updated!
                            </x-action-message>
                        </div>
                    </div>
                </th>
                <th class="p-2 text-left">Venue</th>
            </tr>
            </thead>
            <tbody class="whitespace-nowrap">

            @foreach($date->events as $key => $event)

                <tr wire:key="{{ $event->id }}">
                    <td class="p-4 text-left {{ $event->score1 > 7 ? 'font-semibold text-green-700' : '' }}">
                        {{ $event->team_1->name }}
                    </td>
                    <td class="p-4 text-left {{ $event->score2 > 7 ? 'font-semibold text-green-700' : '' }}">
                        {{ $event->team_2->name }}
                    </td>
                    <td class="p-4 text-center">
                        @can('update', $event)
                            <div class="flex flex-row my-2">
                                <div>
                                    <x-text-input size="2" maxlength="2" wire:model="date.events.{{ $key }}.score1"/>
                                </div>
                                <div class="flex flex-col ml-2">
                                    <div>
                                        <img
                                            class="cursor-pointer"
                                            src="{{ secure_asset('svg/plus-box-fill.svg') }}"
                                            alt=""
                                            title="Add one game"
                                            width="20"
                                            height="20"
                                            wire:click="addOneGameScore1({{ $event->id }})"
                                        >
                                    </div>
                                    <div>
                                        <img
                                            class="cursor-pointer"
                                            src="{{ secure_asset('svg/minus-box-fill.svg') }}"
                                            alt=""
                                            title="Minus one game"
                                            width="20"
                                            height="20"
                                            wire:click="minusOneGameScore1({{ $event->id }})"
                                        >
                                    </div>
                                </div>
                            </div>
                        @else
                            {{ $event->score1 }} - {{ $event->score2 }}
                        @endcan
                    </td>
                    <td class="p-4 text-center">
                        @can('update', $event)
                            <div class="flex flex-row my-2">
                                <div>
                                    <x-text-input size="2" maxlength="2" wire:model.blur="date.events.{{ $key }}.score2"/>
                                </div>
                                <div class="flex flex-col ml-2">
                                    <div>
                                        <img
                                            class="cursor-pointer"
                                            src="{{ secure_asset('svg/plus-box-fill.svg') }}"
                                            alt=""
                                            title="Add one game"
                                            width="20"
                                            height="20"
                                            wire:click="addOneGameScore2({{ $event->id }})"
                                        >
                                    </div>
                                    <div>
                                        <img
                                            class="cursor-pointer"
                                            src="{{ secure_asset('svg/minus-box-fill.svg') }}"
                                            alt=""
                                            title="Minus one game"
                                            width="20"
                                            height="20"
                                            wire:click="minusOneGameScore2({{ $event->id }})"
                                        >
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </td>
                    <td class="p-4 text-left">{{ $event->venue->name }}</td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <div class="p-2">
            <x-input-error :messages="$errors->all()"/>
        </div>
    </div>
</div>
