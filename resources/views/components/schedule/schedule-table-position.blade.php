@props(['table', 'position', 'home'])
<div class="col-span-4 w-full p-1 text-right">
    <div>
        <x-schedule.schedule-dropdown-players :table="$table" :position="$position" :home="true"/>
    </div>
</div>
<div></div>
<div class="col-span-4 w-full p-1">
    <div>
        <x-schedule.schedule-dropdown-players :table="$table" :position="$position" :home="false"/>
    </div>
</div>
