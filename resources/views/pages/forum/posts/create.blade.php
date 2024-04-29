<x-layout>
    @volt()
    <section>
        <x-title title="Create a new Forum Post"/>

        @can('create', \App\Models\Forum\Post::class)
            <livewire:forum.posts.create/>
        @else
            <div class="text-red-700 text-xl">You don't have access to this page</div>
        @endcan

    </section>
    @endvolt
</x-layout>
