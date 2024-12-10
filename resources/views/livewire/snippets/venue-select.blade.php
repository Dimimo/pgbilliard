<div>
    <label for="venue_id">

    </label>
    <select id="venue_id" wire:model.change="venue_id">
        <option readonly>Select venue...</option>
        @foreach($venues as $venue)
            @if($venue->name !== 'BYE')
                <option value="{{ $venue->id }}">{{ $venue->name }}</option>
            @endif
        @endforeach
    </select>
    <x-forms.spinner target="venue_id"/>
</div>
