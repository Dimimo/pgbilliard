<div>
    <x-admin.help.shift :date="$dates->first()"/>

    @if (!is_null($last_played_date))
        <x-forms.sub-title title="{{__('Dates played and should be immutable')}}">
            <div class="my-4 text-center">
                @foreach($dates as $date)
                    @if($date->date < $last_played_date->date)
                        <x-date.shift-buttons :date="$date"/>
                    @endif
                @endforeach
            </div>
        </x-forms.sub-title>
    @endif

    <x-forms.sub-title title="{{ $last_played_date ? __('Dates not played yet') : __('No dates can be changed')}}">
        <div class="my-4 text-center">
            @forelse($mutable_dates as $date)
                <x-date.shift-buttons :date="$date"/>
            @empty
                <div class="font-bold text-red-700">
                    {{__('This Season seems finished, missing (semi) finals')}}
                </div>
            @endforelse
        </div>

        <div class="text-center">
            <x-forms.action-message class="font-bold text-red-700" on="overlaps">
                {{__('Date overlaps')}}
            </x-forms.action-message>
        </div>
    </x-forms.sub-title>
</div>
