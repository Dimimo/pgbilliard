@props(['dates', 'last_day'])
<label for="date_id">{{ __('Playing date') }}</label>
<div class="flex items-center justify-between">
    <select
        class="mb-1 mr-4 block w-auto appearance-none rounded border border-gray-500 bg-white py-1 pl-4 pr-8 text-base leading-normal text-gray-800"
        id="date_id"
        wire:model.change="form.date_id"
    >
        <option value="">-- {{ __('select date') }} --</option>
        @foreach ($dates as $date)
            <option
                value="{{ $date->id }}"
                wire:key="{{ $date->id }}"
                @selected($last_day->id === $date->id)
            >
                {{ $date->date->format('Y-m-d') }}
            </option>
        @endforeach
    </select>

    <div
        class="flex items-center"
        wire:target="dateForm.regular, dateForm.title, selectedDate"
        wire:loading.remove
    >
        <input
            id="regular"
            name="regular"
            type="checkbox"
            value="1"
            class="h-4 w-4 shrink-0 rounded border-gray-700 text-blue-600 focus:ring-blue-500"
            wire:model.live="dateForm.regular"
        />
        <label for="regular" class="ml-3 block text-sm">{{ __('Special date') }}?</label>
    </div>

    <x-forms.spinner target="dateForm.regular, dateForm.title, selectedDate" />

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

            ])
            placeholder="{{ $last_day->regular ? __("Finals? Semi? Other?") : '' }}"
            wire:model.live.debounce.500ms="dateForm.title"
        />
    </label>
</div>
@error('form.date_id')
    <div class="space-y-1 text-sm text-red-600">{{ $message }}</div>
@enderror

@error('dateForm.title')
    <div class="space-y-1 text-sm text-red-600">{{ $message }}</div>
@enderror
