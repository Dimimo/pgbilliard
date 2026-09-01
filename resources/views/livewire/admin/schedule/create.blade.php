<div>
    <article class="my-4 rounded-lg border border-gray-700 bg-green-100 p-4">
        <x-admin.help.day-schedule />
    </article>

    <div class="h-12">
        <x-forms.action-message class="m-8 text-center text-xl" on="format-updated">
            {{ __('The format is updated') }}
        </x-forms.action-message>
    </div>

    @if ($request_format_update)
        <div class="">
            <form class="flex flex-col space-y-2" wire:submit="save">
                <label for="name" class="text-lg">{{ __('Name of the Schedule') }}:</label>
                <input id="name" class="w-96" type="text" wire:model.live="name" />
                <label for="details" class="text-lg">
                    {{ __('A word of explanation') }}
                    <span class="text-sm">
                        ({{ __('optional, up to :chars characters', ['chars' => \App\Constants::SCHEDULE_DETAILS]) }})
                    </span>
                </label>
                <textarea
                    id="details"
                    maxlength="255"
                    wire:model.live.debounce.500ms="details"
                    cols="40"
                    rows="4"
                ></textarea>
                <x-forms.primary-button class="w-min">
                    {{ $format->exists ? __('Update') : __('Create') }}
                </x-forms.primary-button>
                @error ('name')
                    <div class="text-red-700">{{ $message }}</div>
                @enderror
            </form>
        </div>
    @else
        <div class="grid grid-flow-row grid-cols-9 items-center justify-items-center gap-2">
            <div
                class="col-span-9 h-auto w-full rounded-lg border-2 border-indigo-400 bg-indigo-100 pt-2 text-center text-xl"
            >
                <div>
                    {{ __('The format used is') }}
                    <span class="font-bold">{{ $format->name }}</span>
                    <button
                        class="cursor-pointer"
                        wire:click="requestFormatUpdate"
                        title="{{ __("Edit the format's name and details") }}"
                    >
                        <x-svg.pen-to-square-solid color="fill-green-600" size="4" padding="ml-2" />
                    </button>
                </div>

                @if ($details)
                    <div class="m-2 text-center text-sm italic">{{ $details }}</div>
                @endif
                <div class="inline-flex flex-row space-x-2 align-middle">
                    <div class="text-sm">Number of players:</div>
                    <select class="mb-2 rounded-xl text-sm" wire:model.live="players">
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>
            </div>
            <div class="col-span-4 w-full bg-blue-50 p-4 text-right">
                <div class="mb-4 text-lg text-indigo-700">{{ __('Home Team') }}</div>
                @for ($i=1;$i<=$players;$i++)
                    <div>
                        {{ __('Home Team') }} {{ $i }} ({!! trans_choice('plural.games', $format->checkGameNumbers($i, true)) !!})
                    </div>
                @endfor
            </div>
            <div></div>
            <div class="col-span-4 w-full bg-green-50 p-4 text-left">
                <div class="mb-4 text-lg text-green-700">{{ __('Visitors') }}</div>
                @for ($i=1;$i<=$players;$i++)
                    <div>
                        {{ __('Visit') }} {{ $i }} ({!! trans_choice('plural.games', $format->checkGameNumbers($i, false)) !!})
                    </div>
                @endfor
            </div>

            @foreach ($rounds as $i => $round)
                @php
                    $j = $i + 4;
                @endphp

                <div class="col-span-9 h-12 w-full bg-green-100 pt-2 text-center text-xl">
                    {{ $round }} round
                </div>
                @for ($i;$i<$j;$i++)
                    <x-schedule.schedule-table-position
                        :table="$table"
                        :position="$i"
                        :players="$players"
                    />
                @endfor

                <div class="col-span-9 h-12 w-full bg-green-100 pt-2 text-center text-xl">
                    {{ $round }} double
                </div>
                <x-schedule.schedule-table-position
                    :table="$table"
                    :position="$i"
                    :players="$players"
                />
            @endforeach
        </div>
    @endif
</div>
