<div>
    <div id="dates" class="my-4">
        @if ($dates)
            <div class="border border-teal-500 p-6 text-2xl">
                There are <strong>{{ count($dates) }}</strong> playing days in season <strong>{{ $dates->first()->cycle }}</strong><br>
                @if ($converted)
                    <div class="text-green-700">This season has been copied to the new database</div>
                @else
                    <div class="text-red-600">This season has not been copied yet to the new database!</div>
                    <div class="mt-4">
                        <button
                            class="dark-green border border-gray-900 p-2 cursor-pointer"
                            wire:click="convertToNewDB('{{ $dates->first()->cycle }}')"
                            wire:loading.attr="disabled"
                        >
                            Copy the season {{ $dates->first()->cycle }} to the new database!
                        </button>
                        <span class="smaller-80" wire:loading wire:target="convertToNewDB('{{ $dates->first()->cycle }}')">
                            <img src="{{ secure_asset('images/ajax-loader.gif') }}" alt="loading">
                        </span>
                    </div>
                @endif
            </div>
        @else
            <div class="border border-teal-500 p-6 text-xl">
                Select a season first
            </div>
        @endif
    </div>

    <div id="seasons" class="border-2 border-gray-300 bg-gray-50">
        <x-sub-title title='Seasons <span class="text-sm text-gray-700">(puertoparrot database)</span>'>
            <div class="grid grid-cols-8">
                @foreach($seasons as $season)
                @if ($season->done)
                    <div
                        class="border border-blue-600 p-2 bg-green-500 text-center cursor-default"
                        wire:key="{{ $season->cycle }}"
                    >
                        {{ $season->cycle }}
                    </div>
                @else
                    <div
                        class="border border-blue-600 p-2 text-center cursor-pointer"
                        wire:key="{{ $season->cycle }}"
                        wire:click="getDates('{{ $season->cycle }}')"
                    >
                        {{ $season->cycle }}
                    </div>
                @endif
                @endforeach
            </div>
        </x-sub-title>

    </div>


    <div id="message_window">
        @if ($messages)
            <div class="border-2 border-gray-300 bg-gray-50 my-5">
                <h4>Messages output <span class="smaller-80 text-gray-700">(live update, please don't interrupt)</span></h4>
                {!! nl2br($messages) !!}
            </div>
        @endif
    </div>
</div>
