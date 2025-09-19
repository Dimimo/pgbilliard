<div>
    <div class="mb-4 ml-4 border-2 border-gray-500 bg-gray-50 p-2">
        @if ($comment_form->comment->id)
            <div class="mx-3 border-2 border-gray-300 bg-white p-4">
                {!! nl2br($post->body) !!}
            </div>
        @endif

        <form wire:submit="{{ $comment_form->comment->id ? "update" : "create" }}">
            <div class="mt-2 grid justify-items-center">
                <x-forms.input-label for="comment_form.body">
                    {{ __('Your comment') }}
                </x-forms.input-label>
                <div>
                    @error('comment_form.body')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
                <x-forms.text-area
                    id="comment_form.body"
                    class="w-full md:w-3/4"
                    cols="30"
                    rows="5"
                    wire:model="comment_form.body"
                />

                <div class="my-4 grid grid-cols-4 gap-2">
                    <div class="col-start-2 text-right">
                        <x-forms.primary-button>
                            {{ $comment_form->comment->id ? "Update comment" : "Create comment" }}
                        </x-forms.primary-button>
                    </div>
                    <x-forms.spinner target="create, update, delete" />
                    <x-forms.action-message class="mx-3 inline-block" on="comment-saved">
                        {{ __('Saved') }}!
                    </x-forms.action-message>
                    <x-forms.action-message class="mx-3 inline-block" on="comment-updated">
                        {{ __('Updated') }}!
                    </x-forms.action-message>
                    <x-forms.action-message class="mx-3 inline-block" on="comment-deleted">
                        {{ __('Deleted') }}!
                    </x-forms.action-message>
                </div>
            </div>
        </form>
    </div>
</div>
