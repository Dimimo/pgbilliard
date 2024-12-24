@php use Illuminate\Support\Carbon; @endphp
<div>
    <div class="border border-green-500 bg-green-100 p-4 m-2">
        <ul class="px-4 list-disc">
            <li>
                <u><strong>Important</strong></u>:
                If a new venue is introduced, please
                <a
                    class="border border-transparent font-semibold text-blue-700 hover:bg-blue-100 hover:border hover:border-blue-700"
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
                After creating the new season, you will be invited to establish <strong>the teams first</strong>, before the calendar part
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
            <div class="p-2 mt-1 text-right text-xl">
                <x-forms.input-label value="Season"/>
            </div>
            <div class="p-2">
                <x-forms.text-input id="cycle" wire:model.live.debounce.500ms="cycle"/>
                <a wire:click="addMonth">
                    <img class="inline-block cursor-pointer" src="{{ secure_asset('svg/plus-box-fill.svg') }}" alt="" title="Add one month" width="24"
                         height="24">
                </a>
                @if(Carbon::createFromFormat('Y/m', $cycle)->subMonth() > Carbon::now())
                    <a wire:click="subMonth">
                        <img
                            class="inline-block cursor-pointer"
                            src="{{ secure_asset('svg/minus-box-fill.svg') }}"
                            alt=""
                            title="Distract one month"
                            width="24"
                            height="24"
                        >
                    </a>
                @endif
                <div>
                    @error('cycle') <span class="text-red-700">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="p-2 mt-1 text-right text-xl">
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

            <div class="p-2 mt-1 text-right text-xl">
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

            <div class="p-2 mt-1 text-right text-xl">
                <label for="starting_date">
                    The next Season starts at
                </label>
            </div>
            <div class="p-2">
                <x-forms.text-input type="date" id="starting_date" wire:model.live="starting_date"/>
                <a wire:click="addWeek">
                    <img class="inline-block cursor-pointer" src="{{ secure_asset('svg/plus-box-fill.svg') }}" alt="" title="Add one week" width="24"
                         height="24">
                </a>
                @if(Carbon::createFromFormat('Y-m-d', $starting_date)->subWeek() > Carbon::now())
                    <a wire:click="subWeek">
                        <img class="inline-block cursor-pointer" src="{{ secure_asset('svg/minus-box-fill.svg') }}" alt="" title="Distract one week" width="24"
                             height="24">
                    </a>
                @endif
            </div>

            <div class="p-2 mt-1 text-right">
                <div class="flex items-center gap-4">
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
