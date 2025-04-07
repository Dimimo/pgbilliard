<div class="mt-8 flex flex-row flex-nowrap justify-end">
    <div class="mr-4 mt-1">{{__('Select another Season')}}</div>
    <label>
        <select
            class="block appearance-none w-auto py-1 pl-4 pr-8 mr-4 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-500 rounded"
            title="{{__('Select another Season')}}"
            wire:change="changeCycle($event.target.value)"
        >
            @if($cycles)
                @foreach ($cycles as $c)
                    <option
                        value="{{ $c->id }}"
                        @selected($c->cycle === $cycle)
                    >
                        {{ $c->cycle }}
                    </option>
                @endforeach
                @if ($cycle < $c->cycle)
                    <option
                        @selected(true)
                    >
                        {{ $cycle }}
                    </option>
                @endif
                <option value="0">{{__('All Seasons')}}</option>
            @else
                <option>{{__('No seasons are available in the new database')}}</option>
            @endif
        </select>
    </label>
</div>
