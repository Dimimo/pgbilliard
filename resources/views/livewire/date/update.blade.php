@props(['event'])

<tbody class="whitespace-nowrap">
<tr @class(['bg-red-50' => $errors->any(), 'bg-green-50' => $event->id === $event_id,])>
    <td @class([
            'px-2 pt-4 sm:px-4' => $errors->any(),
            'px-2 py-4 sm:p-4' => !$errors->any(),
            'text-right',
            'font-bold text-green-700' => $score1 > 7
        ])>
        {{ $event->team_1->name }}
    </td>
    @if(session('is_admin'))
        @if($confirmed === false && $event->games()->count() === 0)
            <td @class([
                'px-2 pt-4 sm:px-4' => $errors->any(),
                'px-2 py-4 sm:p-4' => !$errors->any(),
            ]) colspan="2">
                <div class="grid grid-cols-1 justify-items-center gap-0 sm:grid-cols-2">
                    <div class="mr-auto sm:mr-2">
                        <x-date.change-score model="score1" :score1="$score1" :score2="$score2"/>
                    </div>
                    <div class="ml-auto sm:ml-2">
                        <x-date.change-score model="score2" :score1="$score1" :score2="$score2"/>
                    </div>
                </div>
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
    @endif

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
            @if (
                (($score1 + $score2 === 15) && ($confirmed === false))
                ||
                ($event->date->regular && (($score1 === 8 || $score2 === 8) && ($confirmed === false)))
            )
                <button
                    type="button"
                    title="{{__('Confirm the final score')}}"
                    class="rounded-lg bg-blue-100 p-2 outline outline-blue-600 hover:bg-green-100 hover:outline-green-600"
                    wire:click="consolidate()"
                    wire:confirm="{{__('Final score is')}} {{ $event->team_1->name }} {{ $score1 }} - {{ $score2 }} {{ $event->team_2->name }}\n{{__("You can't change the score after the confirmation")}}."
                >
                    confirm
                </button>
            @elseif ($event->games()->whereNotNull('win')->count() > 0)
                <a
                    href="{{ route('schedule.event', ['event' => $event]) }}"
                    class="text-blue-800 link"
                    wire:navigate
                >
                    <x-svg.eye-solid color="fill-green-600" size="5" padding=""/>
                    <span class="hidden sm:inline-block">{{__('Day scores')}}</span>
                </a>
            @elseif($event->date->checkOpenWindowAccess())
                <a
                    href="{{ route('schedule.event', ['event' => $event]) }}"
                    class="text-blue-800 link"
                    wire:navigate
                >
                    <x-svg.table-list-solid color="fill-green-600" size="4"/>
                    <span class="hidden sm:inline-block">{{__('Create Day Sheet')}}</span>
                </a>
            @elseif($event->date->date->isFuture())
                <x-date.event-set-in-future :event="$event"/>
            @else
                <x-forms.spinner/>
                <x-forms.action-message class="font-semibold text-green-700" on="scores-updated-{{ $event->id }}">
                    {{__('Updated')}}
                </x-forms.action-message>
                <x-forms.action-message class="font-bold text-green-700" on="score-confirmed-{{ $event->id }}">
                    {{__('Confirmed')}}
                </x-forms.action-message>
            @endif
        @else
            @if ($event->confirmed || $event->games()->whereNotNull('win')->count() > 0)
                <a
                    href="{{ route('schedule.event', ['event' => $event]) }}"
                    class="text-blue-800 link"
                    wire:navigate
                >
                    <x-svg.eye-regular color="fill-sky-600" size="5" padding=""/>
                    <span class="hidden sm:inline-block">{{__('Day scores')}}</span>
                </a>
            @elseif(! $event->date->checkOpenWindowAccess())
                <x-date.event-set-in-future :event="$event"/>
            @else
                <div class="text-sm italic text-gray-600 hidden sm:inline-block">
                    ({{__('ready to start')}})
                </div>
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
