<x-layout>
    @volt
    <div>
        <x-title title="Create a new Season"/>
        @can('create', \App\Models\Season::class)
            <livewire:admin.season.create/>
        @else
            <div class="text-red-700 text-xl">You don't have access to this page</div>
        @endcan
    </div>
    @endvolt
</x-layout>
