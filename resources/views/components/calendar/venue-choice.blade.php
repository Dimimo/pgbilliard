<div>
    <label for="venue_id">
        {{ $slot }}
    </label>
    <select
        class="mb-1 block w-full appearance-none rounded border border-gray-500 bg-white px-2 py-1 text-base leading-normal text-gray-800"
        id="venue_id"
        wire:model.change="form.venue_id"
    >
        <option value="">-- {{ __('Select venue') }} --</option>
        @foreach ($venues as $venue)
            <option value="{{ $venue->id }}" wire:key="{{ $venue->id }}">
                {{ $venue->name }}
            </option>
        @endforeach
    </select>

    @error('form.venue_id')
        <div class="space-y-1 text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>
