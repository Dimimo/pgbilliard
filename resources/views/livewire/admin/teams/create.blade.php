<div class="m-8 flex flex-col items-center">
    <x-title title="{{__('Create a new team')}}" />
    <form wire:submit="save">
        <div class="my-4">
            <label for="name" class="block">Name of the team</label>
            <input
                type="text"
                id="name"
                class="block rounded-md border border-blue-300 p-3 shadow-sm focus:outline-none sm:text-sm"
                wire:model.live.debounce="form.name"
            />
        </div>

        <div class="my-4">
            <label for="venue_id" class="block">The venue (bar) they play at</label>
            <select class="block" id="venue_id" wire:model.live="form.venue_id">
                <option>Select venue...</option>
                @foreach ($form->venues as $venue)
                    <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="my-4">
            <label for="captain_id" class="block">If known, you may select the captain</label>
            <select class="block" id="captain_id" wire:model.live="form.captain_id">
                <option>Select captain...</option>
                @foreach ($form->users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <x-forms.input-error :messages="$errors->all()" />

        <div class="my-4">
            <x-forms.primary-button>Create</x-forms.primary-button>
        </div>
    </form>
</div>
