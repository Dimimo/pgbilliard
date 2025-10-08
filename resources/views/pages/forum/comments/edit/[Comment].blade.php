<?php

use function Livewire\Volt\state;
use function Laravel\Folio\name;

state('comment');

name('forum.comments.edit');
?>

<x-layout>
    @volt
        <section>
            <x-title title="Edit your comment" :subtitle="$comment->post->title" />

            <x-forum.back-to-post :post="$comment->post" />

            @can('update', $comment)
                <livewire:forum.comments.create :comment="$comment" />
            @endcan

            @cannot('update', $comment)
                <div class="text-xl text-red-700">
                    {{ __("You don't have access to this page") }}
                </div>
            @endcannot
        </section>
    @endvolt
</x-layout>
