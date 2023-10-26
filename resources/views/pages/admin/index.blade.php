<x-layout>
    @volt
        <section>
            <x-title title="The Administration menu"/>
            <div class="flex flex-col">
                <x-nav-link href="/admin/venues/create" class="flex justify-center text-xl" :active="false">
                    Create a new Venue
                </x-nav-link>
                <x-nav-link href="/admin/season/create" class="flex justify-center text-xl" :active="false">
                    Create a new Season
                </x-nav-link>
                <x-nav-link href="/admin/overview" class="flex justify-center text-xl" :active="false">
                    Overview of all administrators
                </x-nav-link>
            </div>
        </section>
    @endvolt
</x-layout>
