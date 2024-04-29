<?php

use function Livewire\Volt\state;
use function Laravel\Folio\name;

state('post');

name('forum.post.edit');
?>
<x-layout>
    @volt()
    <section>
        <x-title
            id="comment-show"
            :title="$post->title"
            subtitle="Update your post"
        />

        <x-forum.back-to-posts/>

        <livewire:forum.posts.create :post="$post"/>

    </section>
    @endvolt
</x-layout>
