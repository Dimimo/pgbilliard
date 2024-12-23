<?php

use function Livewire\Volt\state;
use function Laravel\Folio\name;

state('post');
name('forum.posts.show');
?>
<x-layout>
    @volt
    <section>
        <livewire:forum.show :post="$post"/>
    </section>
    @endvolt
</x-layout>
