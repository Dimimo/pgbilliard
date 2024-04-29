<div>
    <div class="border-green-500 border-2 bg-green-100/25 p-6">
        <form wire:submit="{{ $post_form->post->exists() ? "update" : "create" }}">
            <div class="grid justify-items-center">
                <x-input-label for="post_form.title">
                    The title of the post
                </x-input-label>
                <div>
                    @error('post_form.title') <span class="text-red-700">{{ $message }}</span> @enderror
                </div>
                <x-text-input id="post_form.title" class="w-full md:w-3/4" type="text" wire:model="post_form.title"/>
            </div>

            <div class="grid justify-items-center mt-6">
                <x-input-label for="post_form.body">
                    Your message
                </x-input-label>
                <div>
                    @error('post_form.body') <span class="text-red-700">{{ $message }}</span> @enderror
                </div>
                <x-text-area id="post_form.body" class="w-full md:w-3/4" cols="30" rows="5" wire:model="post_form.body"/>
            </div>

            <div class="grid grid-cols-4 gap-2 my-4">
                <div class="text-center col-start-2">
                    <x-primary-button>
                        {{ $post_form->post->exists() ? "Update post" : "Create post" }}
                    </x-primary-button>
                </div>
                <x-spinner target="create, update"/>
                <x-action-message class="inline-block mx-3" on="post-saved">
                    Saved!
                </x-action-message>
                <x-action-message class="inline-block mx-3" on="post-updated">
                    Updated!
                </x-action-message>
                <x-action-message class="inline-block mx-3" on="post-deleted">
                    Deleted!
                </x-action-message>
            </div>
        </form>
    </div>
</div>
