<div class="mt-12 bg-indigo-50 border-t border-t-gray-500 p-2 text-center">
    <div class="text-2xl">&copy; {{ now()->format('Y') }} PG Billiard</div>
    <div class="mb-2 text-lg">
        <a href="{{ route('help.rules') }}" class="inline-block text-blue-800 link" wire:navigate>
            Overview of our PG billiard rules
        </a>
    </div>
    <div class="mb-4">
        <a href="{{ route('schedule.new') }}" class="inline-block text-blue-800 link">
            <x-svg.file-pdf-regular color="fill-green-600" size="4"/>
            Reviewed Day schedule
        </a>
    </div>
    <div class="mb-4">Designed for the Puerto Galera Billiard League</div>
    <div class="text-xs">
        This is an open source project build on Laravel, Livewire, Reverb and Tailwind
    </div>
    <a
        href="https://github.com/Dimimo/pgbilliard"
        target="_blank"
        class="text-xs text-blue-600 hover:bg-blue-50 hover:underline"
    >
        The source code can be found on GitHub
    </a>
</div>
