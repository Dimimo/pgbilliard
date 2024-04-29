<?php

use function Livewire\Volt\state;
use function Laravel\Folio\name;

state('post');

name('forum.post.show');
?>
<x-layout>
    @volt
    <section>
        <x-title
            id="comment-show"
            :title="$post->title"
            subtitle="Created by {{  $post->user->name }} on {{ $post->created_at->format('d-m-Y') }}"
        />

        <x-forum.back-to-posts/>

        <livewire:forum.show :post="$post"/>
        <livewire:forum.comments.index :post="$post"/>

    </section>
    @endvolt
</x-layout>
