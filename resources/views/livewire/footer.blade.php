<div class="mt-12 bg-indigo-50 border-t border-t-gray-500 p-2 text-center">
    <div class="text-2xl">&copy; {{ now()->format('Y') }} PG Billiard</div>
    <div class="mb-2 text-lg">
        <a href="{{ route('help.rules') }}" class="inline-block text-blue-800 link" wire:navigate>
            Overview of our PG billiard rules
        </a>
    </div>
    <div class="mb-4">
        <a href="{{ route('schedule.new') }}" class="inline-block text-blue-800 link">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 512 512"
                class="inline-block w-4 h-4 fill-green-600 mb-1">
                <path d="M64 464l48 0 0 48-48 0c-35.3 0-64-28.7-64-64L0 64C0 28.7 28.7 0 64 0L229.5 0c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3L384 304l-48 0 0-144-80 0c-17.7 0-32-14.3-32-32l0-80L64 48c-8.8 0-16 7.2-16 16l0 384c0 8.8 7.2 16 16 16zM176 352l32 0c30.9 0 56 25.1 56 56s-25.1 56-56 56l-16 0 0 32c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-48 0-80c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24l-16 0 0 48 16 0zm96-80l32 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-32 0c-8.8 0-16-7.2-16-16l0-128c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16l-16 0 0 96 16 0zm80-112c0-8.8 7.2-16 16-16l48 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 32 32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 48c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-64 0-64z"/>
            </svg>
            Reviewed Day schedule PDF download
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
