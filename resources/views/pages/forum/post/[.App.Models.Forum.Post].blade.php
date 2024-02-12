<?php

use function Livewire\Volt\{mount, state};
use function Laravel\Folio\name;

state('post');
/*mount(function ($post)
{
    $this->post = $post;
});*/

name('forum.post.show');
?>
<x-layout>
    @volt
    <section>
        <x-title
            :title="$post->title"
            subtitle="Created by {{  $post->user->name }} on {{ $post->created_at->format('d-m-Y') }}"
        />

        <livewire:forum.post.show :post="$post"/>
        <livewire:forum.comments.index :post="$post"/>

    </section>
    @endvolt
</x-layout>
