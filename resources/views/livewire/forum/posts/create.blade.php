<div>
    <div class="border-2 border-green-500 bg-green-100/25 p-6">
        <form wire:submit="{{ $form->post->id ? "update" : "create" }}">
            <div class="grid justify-items-center">
                <x-forms.input-label for="form.title">
                    Title
                </x-forms.input-label>
                <div>
                    @error('form.title') <span class="text-red-700">{{ $message }}</span> @enderror
                </div>
                <x-forms.text-input
                    id="form.title"
                    class="w-full md:w-3/4"
                    type="text"
                    wire:model="form.title"
                    :maxlength="\App\Constants::FORUM_TITLE"
                />
            </div>

            <div class="mt-6 grid justify-items-center">
                <x-forms.input-label for="form.body">
                    Your message
                </x-forms.input-label>
                <div>
                    @error('form.body') <span class="text-red-700">{{ $message }}</span> @enderror
                </div>
                {{--<x-forms.text-area id="form.body" class="w-full md:w-3/4" cols="30" rows="5" wire:model="form.body"/>--}}
                <div class="w-full">
                    <x-forms.textarea-constrained
                        for="form.body"
                        :value="$form->body"
                        :limit="\App\Constants::FORUM_BODY"
                    />
                </div>

            </div>

            @if(session('is_admin'))
                <x-forms.checkbox for="form.sticky" :checked="$form->is_sticky" wire:model="form.is_sticky">
                    Sticky? <span class="text-sm">(pushed to the top for important messages)</span>
                </x-forms.checkbox>
                <x-forms.checkbox for="form.locked" :checked="$form->is_locked" wire:model="form.is_locked">
                    Locked? <span class="text-sm">(can only be changed by administrators)</span>
                </x-forms.checkbox>
            @endif

            <div class="my-4 grid grid-cols-4 gap-2">
                <div class="col-start-2 text-center">
                    <x-forms.primary-button>
                        {{ $form->post->id ? "Update post" : "Create post" }}
                    </x-forms.primary-button>
                </div>
                <x-forms.spinner target="create, update, delete"/>
                <x-forms.action-message class="mx-3 inline-block" on="post-saved">
                    Saved!
                </x-forms.action-message>
                <x-forms.action-message class="mx-3 inline-block" on="post-updated">
                    Updated!
                </x-forms.action-message>
                <x-forms.action-message class="mx-3 inline-block" on="post-deleted">
                    Deleted!
                </x-forms.action-message>
            </div>
        </form>
    </div>
</div>
