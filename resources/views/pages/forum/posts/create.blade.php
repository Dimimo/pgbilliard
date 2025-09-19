<?php

use App\Models\Forum\Post;
use function Laravel\Folio\name;

name('forum.posts.create');
?>

<x-layout>
    @volt()
        <section>
            <x-title title="Create a new Forum Post" />

            @can('create', Post::class)
                <livewire:forum.posts.create />
            @else
                <div class="text-xl text-red-700">
                    {{ __("You don't have access to this page") }}
                </div>
            @endcan
        </section>
    @endvolt
</x-layout>
