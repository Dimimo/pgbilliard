<?php

use function Laravel\Folio\name;
name('forum.posts.index');

?>
<x-layout>
    @volt()
    <section>
        <livewire:forum.posts.index/>
    </section>
    @endvolt
</x-layout>
