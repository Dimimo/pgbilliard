<?php

use function Laravel\Folio\name;

name('admin.schedule.index')

?>
<x-layout>
    @volt
    <section>
        <x-title title="Overview of Day Schedules"/>
        <livewire:admin.schedule.index/>
    </section>
    @endvolt
</x-layout>
