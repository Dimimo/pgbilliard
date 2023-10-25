<x-layout>
    @volt
        <section>
            <x-title title="The Administration menu"/>
            <x-nav-link href="/admin/venues/create" class="text-xl" :active="false">
                Create a new Venue
            </x-nav-link>
        </section>
    @endvolt
</x-layout>
