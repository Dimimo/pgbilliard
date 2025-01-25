<div>
    <x-admin.help.shift :date="$dates->first()"/>

    <x-forms.sub-title title="Dates played and should be immutable">
        <div class="my-4 text-center">
            @foreach($dates as $date)
                @if($date->date < $last_played_date->date)
                    <x-date.shift-buttons :date="$date"/>
                @endif
            @endforeach
        </div>
    </x-forms.sub-title>

    <x-forms.sub-title title="Dates not played yet">
        <div class="my-4 text-center">
            @foreach($mutable_dates as $date)
                <x-date.shift-buttons :date="$date"/>
            @endforeach
        </div>

        <div class="text-center">
            <x-forms.action-message class="font-bold text-red-700" on="overlaps">
                Date overlaps
            </x-forms.action-message>
        </div>
    </x-forms.sub-title>
</div>
