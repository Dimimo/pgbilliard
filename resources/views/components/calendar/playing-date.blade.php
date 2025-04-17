@props(['dates', 'last_day'])
<label for="date_id">{{__('Playing date')}}</label>
<div class="flex items-center justify-between">
    <select
        class="block appearance-none w-auto py-1 pl-4 pr-8 mr-4 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-500 rounded"
        id="date_id" wire:model.change="event.date_id">
        <option value=""> -- {{__('select date')}} --</option>
        @foreach($dates as $date)
            <option
                value="{{ $date->id }}"
                wire:key="{{ $date->id }}"
                @selected($last_day->id === $date->id)
            >
                {{ $date->date->format('Y-m-d') }}
            </option>
        @endforeach
    </select>

    <div class="flex items-center" wire:target="dateForm.regular, dateForm.title, selectedDate" wire:loading.remove>
        <input
            id="regular"
            name="regular"
            type="checkbox"
            class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-700 rounded"
            wire:model.change="dateForm.regular"
        />
        <label for="regular" class="ml-3 block text-sm">
            {{__('Special date')}}?
        </label>
    </div>

    <x-forms.spinner target="dateForm.regular, dateForm.title, selectedDate"/>

    <label>
        <input
            name="title"
            type="text"
            @class([
                'w-auto',
                'text-sm',
                'px-2',
                'rounded-lg',
                'outline-blue-500',
                'bg-gray-100' => !$last_day->regular,
                'bg-green-100' => $last_day->regular

]           )
            placeholder="{{ $last_day->regular ? __("Finals? Semi? Other?") : '' }}"
            wire:model.live.debounce.500ms="dateForm.title"
        />
    </label>
</div>
@error('event.date_id')
<div class="text-sm text-red-600 space-y-1">{{ $message }}</div>
@enderror
@error('dateForm.title')
<div class="text-sm text-red-600 space-y-1">{{ $message }}</div>
@enderror
