<div>
    <x-title title="Create a new Forum Post"/>

    <div class="border border-green-500 border-2 bg-green-100/25 p-6">
        <form wire:submit="create">
            (form)

            <x-primary-button class="my-5">Submit</x-primary-button>
            <x-spinner target="create"/>
            <x-action-message class="inline-block mx-3" on="post-saved">
                Saved!
            </x-action-message>
        </form>
    </div>
</div>
