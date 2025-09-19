<?php

use function Laravel\Folio\name;

name('rank');
?>

<x-layout>
    @volt
        <div>
            <x-title
                title="{{__('The individual ranking overview')}}"
                subtitle="{{__('Season')}} {{ session('cycle') }}"
                help="ranking"
            />
            <livewire:rank />
        </div>
    @endvolt
</x-layout>
