<?php
use function Livewire\Volt\{computed, state};
use Livewire\Volt\Component;

new class extends Component {

    public function mount()
    {
        //
    }
}

?>
<x-layout>
    @volt
    <div>
        <livewire:score />
    </div>
    @endvolt
</x-layout>
