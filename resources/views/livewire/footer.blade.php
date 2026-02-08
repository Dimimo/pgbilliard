<div class="mt-12 border-t border-t-gray-500 bg-indigo-50 p-2 pb-10 text-center">
    <div class="text-xl">&copy; {{ now()->format('Y') }} PG Billiard League</div>
    <div class="mb-2 text-lg">
        <a href="{{ route('help.rules') }}" class="link inline-block text-blue-800" wire:navigate>
            {{ __('Overview of our PG billiard rules') }}
        </a>
    </div>
    <div
        class="mx-auto mb-4 w-min whitespace-nowrap rounded-xl border border-indigo-700 bg-indigo-100 px-4 py-2"
    >
        <div>
            <a href="{{ route('schedule.original') }}" class="link inline-block text-blue-800">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                    class="mb-1 inline-block h-4 w-4 fill-green-600"
                >
                    <path
                        d="M64 464l48 0 0 48-48 0c-35.3 0-64-28.7-64-64L0 64C0 28.7 28.7 0 64 0L229.5 0c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3L384 304l-48 0 0-144-80 0c-17.7 0-32-14.3-32-32l0-80L64 48c-8.8 0-16 7.2-16 16l0 384c0 8.8 7.2 16 16 16zM176 352l32 0c30.9 0 56 25.1 56 56s-25.1 56-56 56l-16 0 0 32c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-48 0-80c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24l-16 0 0 48 16 0zm96-80l32 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-32 0c-8.8 0-16-7.2-16-16l0-128c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16l-16 0 0 96 16 0zm80-112c0-8.8 7.2-16 16-16l48 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 32 32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 48c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-64 0-64z"
                    />
                </svg>
                <span class="font-bold">{{ __('The Original') }}</span>
                {{ __('Day schedule PDF download') }}
            </a>
        </div>
        <div>
            <a href="{{ route('schedule.new') }}" class="link inline-block text-blue-800">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                    class="mb-1 inline-block h-4 w-4 fill-green-600"
                >
                    <path
                        d="M64 464l48 0 0 48-48 0c-35.3 0-64-28.7-64-64L0 64C0 28.7 28.7 0 64 0L229.5 0c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3L384 304l-48 0 0-144-80 0c-17.7 0-32-14.3-32-32l0-80L64 48c-8.8 0-16 7.2-16 16l0 384c0 8.8 7.2 16 16 16zM176 352l32 0c30.9 0 56 25.1 56 56s-25.1 56-56 56l-16 0 0 32c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-48 0-80c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24l-16 0 0 48 16 0zm96-80l32 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-32 0c-8.8 0-16-7.2-16-16l0-128c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16l-16 0 0 96 16 0zm80-112c0-8.8 7.2-16 16-16l48 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 32 32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 48c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-64 0-64z"
                    />
                </svg>
                <span class="font-bold">{{ __('Reviewed') }}</span>
                {{ __('Day schedule PDF download') }}
            </a>
        </div>
    </div>
    <div class="my-4">
        <a
            title="Download the Google Play app"
            href="https://play.google.com/store/apps/details?id=com.pgbilliard&pcampaignid=web_share"
            target="_blank"
        >
            <x-svg.google-play size="16" />
        </a>
        <a
            class="mb-1 inline-block text-green-700"
            href="{{ route('help.google-play') }}"
            wire:navigate
        >
            <x-svg.circle-question-regular color="fill-green-700" size="6" />
        </a>
    </div>
    <div class="mb-4">
        <a
            href="{{ route('privacy-policy') }}"
            class="link inline-block text-blue-800"
            wire:navigate
        >
            <x-svg.key-solid color="fill-green-600" size="4" />
            {{ __('Privacy Policy') }}
        </a>
    </div>
    <!-- START Language Selection -->
    <div class="mb-4 inline-block">
        <label for="locale-select-dropdown">Select your preferred language</label>
        <select
            id="locale-select-dropdown"
            class="w-auto appearance-none rounded border border-gray-500 bg-white py-1 pl-4 pr-8 text-base leading-normal text-gray-800"
            title="Select your preferred language"
            wire:change="setLocale($event.target.value)"
        >
            @foreach (config('app.available_locales') as $language => $locale)
                <option value="{{ $locale }}" @selected(app()->getLocale() === $locale)>
                    {{-- @include('components.svg.flag-en', ['size' => 10]) --}}
                    {{ $language }}
                </option>
            @endforeach
        </select>
    </div>
    <!-- END Language Selection -->
    <div class="text-xs">
        {{ __('This is an open source project build on Laravel, Livewire and Tailwind') }}
    </div>
    <a
        href="https://github.com/Dimimo/pgbilliard"
        target="_blank"
        class="text-xs text-blue-600 hover:bg-blue-50 hover:underline"
    >
        {{ __('The source code can be found on GitHub') }}
    </a>
</div>
