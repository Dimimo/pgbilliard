<div class="flex justify-center">
    <table class="border-separate border-spacing-2">
        <thead class="whitespace-nowrap">
            <tr class="bg-gray-100">
                <th class="p-2 text-left font-semibold text-gray-900">{{ __('Date') }}</th>
                <th class="p-2 text-left text-red-700">{{ __('Home Team') }}</th>
                <th class="p-2 text-left text-blue-700">{{ __('Visitor') }}</th>
                <th class="p-2 text-center text-gray-900">{{ __('Score') }}</th>
            </tr>
        </thead>
        <tbody class="whitespace-nowrap">
            @foreach ($dates as $date)
                @foreach ($date->events as $event)
                    @if ($team->id === $event->team_1->id)
                        <tr>
                            <td class="hidden p-2 sm:table-row">
                                <div class="flex justify-start">
                                    {{-- todo: add the pdf file --}}
                                    {{--
                                        <div class="mr-2">
                                        <a href="#" title="download this personalized day schedule" wire:navigate>
                                        <x-svg.file-pdf-regular color="fill-green-600" size="5" padding="mb-1"/>
                                        </a>
                                        </div>
                                    --}}
                                    <div>
                                        <a
                                            href="{{ route('dates.show', ['date' => $date]) }}"
                                            class="link"
                                            wire:navigate
                                        >
                                            {{ $event->date->date->format('jS \o\f M Y') }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="table-row sm:hidden">
                                <div class="flex justify-start">
                                    {{-- todo: add the pdf file --}}
                                    {{--
                                        <div class="mr-2">
                                        <a href="#" title="download this personalized day schedule" wire:navigate>
                                        <x-svg.file-pdf-regular color="fill-green-600" size="5" padding="mb-1"/>
                                        </a>
                                        </div>
                                    --}}
                                    <div>
                                        <a
                                            href="{{ route('dates.show', ['date' => $date]) }}"
                                            class="link"
                                            wire:navigate
                                        >
                                            {{ $event->date->date->format('d/m') }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="p-2 text-green-600">
                                <strong>{{ @$team->name }}</strong>
                            </td>
                            <td class="p-2">
                                <a
                                    href="{{ route('teams.show', ['team' => $event->team_2]) }}"
                                    wire:navigate
                                >
                                    {{ $event->team_2->name }}
                                </a>
                            </td>
                            <td class="p-2 text-center">
                                @if ($event->team_2->name === 'BYE')
                                    <span class="green">BYE</span>
                                @elseif (!is_null($event->score1))
                                    <strong
                                        class="{{ $event->score1 > 7 ? 'font-bold text-green-700' : 'text-red-700' }}"
                                    >
                                        {{ $event->score1 }}
                                    </strong>
                                    /{{ $event->score2 }}
                                @elseif ($event->score1 === 0 && $event->score2 === 0)
                                    <span class="red">{{ __('Not in') }}</span>
                                @else
                                    ----
                                @endif
                            </td>
                        </tr>
                    @elseif ($team->id === $event->team_2->id)
                        <tr>
                            <td class="hidden p-2 sm:table-row">
                                <div class="flex justify-start">
                                    {{-- todo: add the pdf file --}}
                                    {{--
                                        <div class="mr-2">
                                        <a href="#" title="download this personalized day schedule" wire:navigate>
                                        <x-svg.file-pdf-regular color="fill-green-600" size="5" padding="mb-1"/>
                                        </a>
                                        </div>
                                    --}}
                                    <div>
                                        <a
                                            href="{{ route('dates.show', ['date' => $date]) }}"
                                            class="link"
                                            wire:navigate
                                        >
                                            {{ $event->date->date->format('jS \o\f M Y') }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="table-row sm:hidden">
                                <div class="flex justify-start">
                                    {{-- todo: add the pdf file --}}
                                    {{--
                                        <div class="mr-2">
                                        <a href="#" title="download this personalized day schedule" wire:navigate>
                                        <x-svg.file-pdf-regular color="fill-green-600" size="5" padding="mb-1"/>
                                        </a>
                                        </div>
                                    --}}
                                    <div>
                                        <a
                                            href="{{ route('dates.show', ['date' => $date]) }}"
                                            class="link"
                                            wire:navigate
                                        >
                                            {{ $event->date->date->format('d/m') }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="p-2">
                                <a
                                    href="{{ route('teams.show', ['team' => $event->team_1]) }}"
                                    wire:navigate
                                >
                                    {{ $event->team_1->name }}
                                </a>
                            </td>
                            <td class="p-2 text-green-600">
                                <strong>{{ @$team->name }}</strong>
                            </td>
                            <td class="text-center">
                                @if ($event->team_2->name === 'BYE')
                                    <span class="green">BYE</span>
                                @elseif (!is_null($event->score2))
                                    {{ $event->score1 }}/
                                    <strong
                                        class="{{ $event->score2 > 7 ? 'font-bold text-green-700' : 'text-red-700' }}"
                                    >
                                        {{ $event->score2 }}
                                    </strong>
                                @elseif ($event->score1 === 0 && $event->score2 === 0)
                                    <span class="red">{{ __('Not in') }}</span>
                                @else
                                    ----
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
