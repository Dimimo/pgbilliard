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
    @can('update', $event)
        @if($confirmed === false)
            <td @class([
            'px-2 pt-4 sm:px-4' => $errors->any(),
            'px-2 py-4 sm:p-4' => !$errors->any(),
        ])>
                <x-date.change-score model="score1" :score1="$score1" :score2="$score2"/>
            </td>
            <td @class([
            'px-2 pt-4 sm:px-4' => $errors->any(),
            'px-2 py-4 sm:p-4' => !$errors->any(),
        ])>
                <x-date.change-score model="score2" :score1="$score1" :score2="$score2"/>

            </td>
        @else
            <td colspan="2" @class([
            'px-2 pt-4 sm:px-4' => $errors->any(),
            'px-2 py-4 sm:p-4' => !$errors->any(),
        ])>
                <x-date.show-score :score1="$score1" :score2="$score2"/>
            </td>
        @endif
    @else
        <td colspan="2" @class([
            'px-2 pt-4 sm:px-4' => $errors->any(),
            'px-2 py-4 sm:p-4' => !$errors->any(),
        ])>
            <x-date.show-score :score1="$score1" :score2="$score2"/>
        </td>
    @endcan

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
        ])>
        @can('update', $event)
            @if (($score1 + $score2 === 15) && ($confirmed === false))
                <button
                    type="button"
                    title="Confirm the final score"
                    class="rounded-lg bg-blue-100 p-2 outline outline-blue-600 hover:bg-green-100 hover:outline-green-600"
                    wire:click="consolidate()"
                    wire:confirm="Final score is {{ $event->team_1->name }} {{ $score1 }} - {{ $score2 }} {{ $event->team_2->name }}\nYou can't change the score after the confirmation."
                >
                    confirm
                </button>
            @else
                <x-forms.spinner/>
                <x-forms.action-message class="font-semibold text-green-700" on="scores-updated-{{ $event->id }}">
                    Updated
                </x-forms.action-message>
                <x-forms.action-message class="font-bold text-green-700" on="score-confirmed-{{ $event->id }}">
                    Confirmed
                </x-forms.action-message>
            @endif
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
