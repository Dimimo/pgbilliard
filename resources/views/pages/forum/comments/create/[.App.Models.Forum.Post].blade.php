<?php

use function Livewire\Volt\state;
use function Laravel\Folio\name;

state('post');

name('forum.comment.create');
?>

<x-layout>
    @volt
    <section>
        <x-title
            title="Write a comment"
            :subtitle="$post->title"
        />

        <x-forum.back-to-post :post="$post"/>
        <x-forum.back-to-posts/>

        @can('create', \App\Models\Forum\Comment::class)

            <livewire:forum.comments.create :comment="new \App\Models\Forum\Comment(['post_id' => $post->id])" :post="$post"/>

        @else
            <div class="text-red-700 text-xl">You don't have access to this page</div>
        @endcan

        @endvolt
    </section>
</x-layout>


