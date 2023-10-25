<div>
    @volt
        <x-layout>
            @can('create', new \App\Models\Venue())
                <x-title title="Create a new venue"/>
                <livewire:admin.venues.create
                    :venue="new \App\Models\Venue(['name' => ''])"
                />
            @endcan
        </x-layout>
    @endvolt
</div>
