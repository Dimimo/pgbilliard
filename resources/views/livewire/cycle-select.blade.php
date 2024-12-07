<div>
    <div class="mr-1 mt-n5 mb-4">
        <div class="col-auto ml-auto">
            <label>
                <select class="mt-n4" title="Change the season" wire:model.live="cycle">
                    <option value="">-- select --</option>
                    @if($cycles)
                        @foreach ($cycles as $c)
                            <option value="{{ $c->id }}" @selected($c->cycle === $cycle)>{{ $c->cycle }}</option>
                        @endforeach
                        @if ($c->cycle > $cycle)
                            <option value="{{ $c->id }}" selected>{{ $c->cycle }}</option>
                        @endif
                        <option value="all">All Seasons</option>
                    @else
                        <option>No seasons are available in the new database</option>
                    @endif
                </select>
            </label>
        </div>
    </div>
</div>
