<?php

use function Livewire\Volt\state;
use function Laravel\Folio\name;

state('post');

name('forum.posts.edit');
?>
<x-layout>
    @volt()
    <section>
        <x-title
            id="comment-show"
            :title="$post->title"
            subtitle="Update your post"
        />

        @can('update', $post)

            @if($post->exists())
                <x-forum.back-to-post :post="$post"/>
            @endif

            <x-forum.back-to-posts/>
            <livewire:forum.posts.create :post="$post"/>

        @else

            <x-forum.back-to-posts/>
            <div class="text-red-700 text-xl">{{__("You don't have access to this page")}}</div>

        @endcan

    </section>
    @endvolt
</x-layout>
