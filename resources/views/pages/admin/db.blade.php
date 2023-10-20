<?php

use Livewire\Volt\Component;
use function Laravel\Folio\{middleware};

middleware(['web']);

new class extends Component {
    //
}
?>
<x-layout>
    @volt()
    <div>
        <livewire:admin.database />
    </div>
    @endvolt
</x-layout>
