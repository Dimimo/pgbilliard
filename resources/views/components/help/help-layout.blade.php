<div class="m-4">
    <div class="mb-4 flex justify-between p-4 border-b-2 border-gray-300" title="close">
        <div>
            <x-svg.circle-question-regular color="fill-green-600" size="6"/>
        </div>
        <div class="text-green-700 text-lg">Scoreboard help</div>
        <button wire:click="$dispatch('closeModal')" class="">
            <x-svg.xmark-solid color="fill-gray-600" size="6" padding=""/>
        </button>
    </div>

    <div class="block">
        {{ $slot }}
    </div>

    <div class="mt-4 flex justify-end p-4" title="close">
        <button wire:click="$dispatch('closeModal')" class="">
            <x-svg.xmark-solid color="fill-gray-600" size="6" padding=""/>
        </button>
    </div>
</div>