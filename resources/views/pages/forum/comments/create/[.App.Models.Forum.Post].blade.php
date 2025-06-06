<?php

use App\Models\Forum\Comment;
use function Laravel\Folio\name;
use function Livewire\Volt\state;

state('post');

name('forum.comments.update');
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

        @can('update', Comment::class)

            <livewire:forum.comments.create :comment="new \App\Models\Forum\Comment(['post_id' => $post->id])" :post="$post"/>

        @else
            <div class="text-red-700 text-xl">{{__("You don't have access to this page")}}</div>
        @endcan

        @endvolt
    </section>
</x-layout>


