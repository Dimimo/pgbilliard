@props(['model', 'score1', 'score2'])
<div class="my-2 flex flex-row items-center">
    <button title="{{__('Minus one game')}}" wire:click="change('{{ $model }}', 'decrement')">
        <x-svg.square-minus-solid color="fill-orange-400" size="10" padding="mr-1"/>
    </button>

    <x-forms.text-input size="2" maxlength="2" class="w-12" wire:model.live.debounce.1000ms="{{ $model }}"/>

    <button title="{{__('Add one game')}}" wire:click="change('{{ $model }}')">
        <x-svg.square-plus-solid color="fill-green-600" size="10" padding="ml-1"/>
    </button>
</div>
