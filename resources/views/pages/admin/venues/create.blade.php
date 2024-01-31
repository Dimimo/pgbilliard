<x-layout>
    @volt
    <section>
        @can('create', new \App\Models\Venue())
            <x-title title="Create a new venue"/>
            <livewire:admin.venues.create :venue="new \App\Models\Venue(['name' => ''])"/>
        @endcan
    </section>
    @endvolt
</x-layout>
