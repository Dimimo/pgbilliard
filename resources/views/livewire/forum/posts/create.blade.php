<div>
    <div class="border-green-500 border-2 bg-green-100/25 p-6">
        <form wire:submit="{{ $post_form->post->id ? "update" : "create" }}">
            <div class="grid justify-items-center">
                <x-input-label for="post_form.title">
                    Title
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

            @if(Auth::user()->isAdmin())
                <x-checkbox for="post_form.sticky" :checked="$post_form->is_sticky" wire:model="post_form.is_sticky">
                    Sticky? <span class="text-sm">(pushed to the top for important messages)</span>
                </x-checkbox>
                <x-checkbox for="post_form.locked" :checked="$post_form->is_locked" wire:model="post_form.is_locked">
                    Locked? <span class="text-sm">(can only be changed by administrators)</span>
                </x-checkbox>
            @endif

            <div class="grid grid-cols-4 gap-2 my-4">
                <div class="text-center col-start-2">
                    <x-primary-button>
                        {{ $post_form->post->id ? "Update post" : "Create post" }}
                    </x-primary-button>
                </div>
                <x-spinner target="create, update, delete"/>
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
