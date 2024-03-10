<?php

use function Laravel\Folio\name;
name('forum.posts.index');

?>
<x-layout>
    @volt()
    <section>
        <livewire:forum.posts.index/>
    </section>

    <x-filament::modal id="open-post">
        {{-- Modal content --}}
    </x-filament::modal>

    <script>
        $this->dispatch('open-modal', id:'open-post')
    </script>
    @endvolt
</x-layout>
