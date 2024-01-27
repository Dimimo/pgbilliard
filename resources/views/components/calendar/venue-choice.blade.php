<label for="venue_id">
    {{ $slot }}
</label>
<select
    class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-500 rounded"
    id="venue_id" wire:model="event.venue_id">
    <option value=""> -- select a Venue --</option>
    @foreach($venues as $venue)

        <option value="{{ $venue->id }}" wire:key="{{ $venue->id }}">{{ $venue->name }}</option>
    @endforeach
</select>
@error('event.venue_id')
<div class="text-sm text-red-600 space-y-1">{{ $message }}</div> @enderror
