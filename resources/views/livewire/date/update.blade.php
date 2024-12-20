<tbody class="whitespace-nowrap">
<tr @class(['bg-red-50' => $errors->any()])>
    <td @class([
            'px-2 pt-4 sm:px-4' => $errors->any(),
            'px-2 py-4 sm:p-4' => !$errors->any(),
            'text-left',
            'font-bold text-green-700' => $score1 > 7
        ])>
        {{ $event->team_1->name }}
    </td>
    <td @class([
            'px-2 pt-4 sm:px-4' => $errors->any(),
            'px-2 py-4 sm:p-4' => !$errors->any(),
            'text-left',
            'font-bold text-green-700' => $score2 > 7
        ])>
        {{ $event->team_2->name }}
    </td>
    <td @class([
            'px-2 pt-4 sm:px-4' => $errors->any(),
            'px-2 py-4 sm:p-4' => !$errors->any(),
            'text-center',
        ])>
        @can('update', $event)
            @if($confirmed === false)

                <x-date.change-score model="score1" :score1="$score1" :score2="$score2"/>

            @else
                <span @class(['text-base' =>  $score1 <= 7, 'text-lg font-bold text-green-700' => $score1 > 7])>
                    {{ $score1 }}
                </span> - <span @class(['text-base' =>  $score2 <= 7, 'text-lg font-bold text-green-700' => $score2 > 7])>
                    {{ $score2 }}
                </span>
            @endif
        @else
            {{ $score1 }} - {{ $score2 }}
        @endcan
    </td>
    <td @class([
            'px-2 pt-4 sm:px-4' => $errors->any(),
            'px-2 py-4 sm:p-4' => !$errors->any(),
            'text-center',
        ])>
        @can('update', $event)
            @if($confirmed === false)

                <x-date.change-score model="score2" :score1="$score1" :score2="$score2"/>

            @endif
        @endcan
    </td>
    <td @class([
            'px-2 pt-4 sm:px-4' => $errors->any(),
            'px-2 py-4 sm:p-4' => !$errors->any(),
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
    <tr>
        <td colspan="5" class="text-center">
            @error('score1') <span class="text-red-700">{{ $message }}</span> @enderror
            @error('score2') <span class="text-red-700">{{ $message }}</span> @enderror
        </td>
    </tr>
@endif
</tbody>
