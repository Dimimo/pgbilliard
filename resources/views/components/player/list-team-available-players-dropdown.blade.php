@props(['available_players'])

<div class="flex flex-col items-center justify-center">
    <div class="mt-1 p-2 text-xl">
        <label for="user_id">
            {{ __('Select a player from the users table') }}
        </label>
    </div>
    <select id="user_id" wire:model.change="user_id">
        <option>-- select --</option>
        @foreach ($available_players->pluck('name', 'id') as $id => $name)
            <option wire:key="add-{{ $id }}" value="{{ $id }}">
                {{ $name }}
            </option>
        @endforeach
    </select>
</div>

<div class="flex justify-center p-2 text-sm italic text-gray-500">
    If the player you are looking for is not in the list, (s)he is probably assigned to another team
    or is new.
</div>
