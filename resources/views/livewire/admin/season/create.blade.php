@php use Illuminate\Support\Carbon; @endphp
<div>
    <div class="m-2 rounded-lg border border-green-500 bg-green-100 p-4">
        <ul class="list-disc px-4">
            <li>
                <u><strong>Important</strong></u>:
                If a new venue is introduced, please
                <a
                    class="border border-transparent font-semibold text-blue-700 hover:border hover:border-blue-700 hover:bg-blue-100"
                    href="{{ route('admin.venues.create') }}"
                    wire:navigate
                >
                    create the venue first
                </a>
            </li>
            <li>
                The BYE option will automatically be checked if the number of teams is uneven
            </li>
            <li>
                The first playing date will be created as a starting point to publish the calendar, the date can still be updated
            </li>
            <li>
                After creating the new season, you will be invited to chose <strong>the participating teams</strong>, before the calendar part
            </li>
            <li>
                Last but not least, <strong>you won't be able to change</strong> the Season {{ $cycle }} setting after creation
            </li>
            <li>
                On the other hand, <strong>you will be able</strong> to change the number of teams participating and the BYE option later on
            </li>
        </ul>
    </div>
    <form wire:submit="save">
        <div class="grid grid-cols-2 gap-4">
            <div class="mt-1 p-2 text-right text-xl">
                <x-forms.input-label value="Season"/>
            </div>
            <div class="p-2">
                <x-forms.text-input id="cycle" wire:model.live.debounce.500ms="cycle"/>
                <a class="cursor-pointer" wire:click="addMonth">
                    <x-svg.square-plus-solid color="fill-green-600" size="5" padding="mb-1"/>
                </a>
                @if(Carbon::createFromFormat('Y/m', $cycle)->subMonth()->format('Ym') >= Carbon::now()->format('Ym'))
                    <a class="cursor-pointer" wire:click="subMonth">
                        <x-svg.square-minus-solid color="fill-orange-500" size="5" padding="mb-1"/>
                    </a>
                @endif
                <div>
                    @error('cycle') <span class="text-red-700">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-1 p-2 text-right text-xl">
                <label for="number_of_teams">
                    Number of teams
                </label>
            </div>
            <div class="p-2">
                <select id="number_of_teams" wire:model.live="number_of_teams">
                    @for ($i = 2; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="p-2 text-right text-xl">
                <label for="has_bye">
                    Is a BYE needed?
                </label>
            </div>
            <div class="p-2">
                <input id="has_bye" type="checkbox" wire:model="has_bye">
            </div>

            <div class="mt-1 p-2 text-right text-xl">
                <label for="day_of_week">
                    The weekday we are playing
                </label>
            </div>
            <div class="p-2">
                <select id="day_of_week" wire:model.live="day_of_week">
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
            </div>

            <div class="mt-1 p-2 text-right text-xl">
                <label for="starting_date">
                    The next Season starts at
                </label>
            </div>
            <div class="p-2">
                <x-forms.text-input type="date" id="starting_date" wire:model.live="starting_date"/>
                <a class="cursor-pointer" wire:click="addWeek">
                    <x-svg.square-plus-solid color="fill-green-600" size="5" padding="mb-1"/>
                </a>
                @if(Carbon::createFromFormat('Y-m-d', $starting_date)->subWeek() > Carbon::now())
                    <a class="cursor-pointer" wire:click="subWeek">
                        <x-svg.square-minus-solid color="fill-orange-500" size="5" padding="mb-1"/>
                    </a>
                @endif
            </div>

            <div class="col-span-2 p-2">
                <div class="flex justify-center gap-4">
                    <x-forms.primary-button>Create</x-forms.primary-button>
                    <x-forms.spinner target="save"/>
                    <x-forms.action-message class="mx-3" on="season-created">
                        Saved!
                    </x-forms.action-message>
                </div>
            </div>
        </div>
    </form>
</div>
