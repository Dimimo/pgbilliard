<div>
    @if ($switches->get('chooseFormat'))
        @can('update', $event)
            <div class="my-8" wire:transition.duration.250ms>
                <x-forms.sub-title title="{{__('Choose a day games format')}}">
                    <div class="flex justify-center">
                        @foreach (App\Models\Format::orderByDesc('name')->get() as $f)
                            <button
                                class="m-2 w-full cursor-pointer rounded-lg border border-green-500 bg-green-100 p-2 text-left"
                                wire:click="$parent.formatChosen({{ $f->id }})"
                            >
                                <div class="text-lg">{{ $f->name }}</div>
                                <div class="text-sm">{{ $f->details }}</div>
                            </button>
                        @endforeach
                    </div>
                </x-forms.sub-title>
            </div>
        @endcan
    @endif
</div>
