<tbody class="whitespace-nowrap">
<tr @class(['bg-red-50' => $errors->any()])>
    <td @class([
            'px-4 pt-2' => $errors->any(),
            'p-4' => !$errors->any(),
            'text-left',
            'font-bold text-green-700' => $score1 > 7
        ])>
        {{ $event->team_1->name }}
    </td>
    <td @class([
            'px-4 pt-2' => $errors->any(),
            'p-4' => !$errors->any(),
            'text-left',
            'font-bold text-green-700' => $score2 > 7
        ])>
        {{ $event->team_2->name }}
    </td>
    <td @class([
            'px-4 pt-2' => $errors->any(),
            'p-4' => !$errors->any(),
            'text-center',
        ])>
        @can('update', $event)
            <div class="my-2 flex flex-row items-center">
                <div class="mr-2">
                    <img
                        class="cursor-pointer"
                        src="{{ secure_asset('svg/minus-box-fill.svg') }}"
                        alt=""
                        title="Minus one game"
                        width="35"
                        height="35"
                        wire:click="change('score1', 'decrement')"
                    >
                </div>
                <div>
                    <x-forms.text-input size="2" maxlength="2" wire:model.live.debounce.1000ms="score1"/>
                </div>
                <div class="ml-2">
                    <img
                        class="cursor-pointer"
                        src="{{ secure_asset('svg/plus-box-fill.svg') }}"
                        alt=""
                        title="Add one game"
                        width="35"
                        height="35"
                        wire:click="change('score1')"
                    >
                </div>
            </div>
        @else
            {{ $score1 }} - {{ $score2 }}
        @endcan
    </td>
    <td @class([
            'px-4 pt-2' => $errors->any(),
            'p-4' => !$errors->any(),
            'text-center',
        ])>
        @can('update', $event)
            <div class="my-2 flex flex-row items-center">
                <div class="mr-2">
                    <img
                        class="cursor-pointer"
                        src="{{ secure_asset('svg/minus-box-fill.svg') }}"
                        alt=""
                        title="Minus one game"
                        width="35"
                        height="35"
                        wire:click="change('score2', 'decrement')"
                    >
                </div>
                <div>
                    <x-forms.text-input size="2" maxlength="2" wire:model.live.debounce.1000ms="score2"/>
                </div>
                <div class="ml-2">
                    <img
                        class="cursor-pointer"
                        src="{{ secure_asset('svg/plus-box-fill.svg') }}"
                        alt=""
                        title="Add one game"
                        width="35"
                        height="35"
                        wire:click="change('score2')"
                    >
                </div>
            </div>
        @endcan
    </td>
    <td @class([
            'px-4 pt-2' => $errors->any(),
            'p-4' => !$errors->any(),
            'text-center',
        ])>
        @can('update', $event)
            @if (($score1 + $score2 === 15) && ($confirmed === false))
                <button
                    type="button"
                    title="Confirm the final score"
                    class="rounded-lg bg-blue-100 p-2 outline outline-blue-600 hover:bg-green-100 hover:outline-green-600"
                    wire:click="consolidate()"
                >
                    confirm
                </button>
            @else
                {{ $event->venue->name }}
            @endif
        @else
            {{ $event->venue->name }}
        @endcan
    </td>
</tr>
@if($errors->any())
    <tr class="">
        <td colspan="5" class="text-center">
            @error('score1') <span class="text-red-700">{{ $message }}</span> @enderror
            @error('score2') <span class="text-red-700">{{ $message }}</span> @enderror
        </td>
    </tr>
@endif
</tbody>
