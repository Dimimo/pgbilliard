<?php

use App\Models\User;
use function Livewire\Volt\
{computed, state};
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
        The teams page
    </div>
    @endvolt
</x-layout>
