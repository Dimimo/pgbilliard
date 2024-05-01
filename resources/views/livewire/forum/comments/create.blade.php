<div>
    <div class="border-gray-500 border-2 bg-gray-50 p-2 ml-4 mb-4">
        @if($comment_form->comment->id)
            <div class="mx-3 p-4 border-2 border-gray-300 bg-white">
                {!! nl2br($post->body) !!}
            </div>
        @endif

        <form wire:submit="{{ $comment_form->comment->id ? "update" : "create" }}">
            <div class="grid justify-items-center mt-2">
                <x-input-label for="comment_form.body">
                    Your comment
                </x-input-label>
                <div>
                    @error('comment_form.body') <span class="text-red-700">{{ $message }}</span> @enderror
                </div>
                <x-text-area id="comment_form.body" class="w-full md:w-3/4" cols="30" rows="5" wire:model="comment_form.body"/>

                <div class="grid grid-cols-4 gap-2 my-4">
                    <div class="text-right col-start-2">
                        <x-primary-button>
                            {{ $comment_form->comment->id ? "Update comment" : "Create comment" }}
                        </x-primary-button>
                    </div>
                    <x-spinner target="create, update, delete"/>
                    <x-action-message class="inline-block mx-3" on="comment-saved">
                        Saved!
                    </x-action-message>
                    <x-action-message class="inline-block mx-3" on="comment-updated">
                        Updated!
                    </x-action-message>
                    <x-action-message class="inline-block mx-3" on="comment-deleted">
                        Deleted!
                    </x-action-message>
                </div>
            </div>
        </form>
    </div>
</div>
