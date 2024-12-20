@props(['model', 'score1', 'score2'])
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
        <x-forms.text-input size="2" maxlength="2" class="w-12" wire:model.live.debounce.1000ms="{{ $model }}"/>
    </div>
    <div class="ml-2">
        <img
            class="cursor-pointer"
            src="{{ secure_asset('svg/plus-box-fill.svg') }}"
            alt=""
            title="Add one game"
            width="35"
            height="35"
            wire:click="change('{{ $model }}')"
        >
    </div>
</div>
