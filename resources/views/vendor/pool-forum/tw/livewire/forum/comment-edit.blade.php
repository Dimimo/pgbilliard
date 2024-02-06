<div>
    <form id="post-form-{{$post->id}}">
        <div class="mb-4">
            <label>
                <textarea
                    wire:model="comment"
                    class="bg-white border border-gray-300 focus:outline-none focus:shadow-outline mt-4 px-3 py-2 rounded text-gray-800 w-full"
                    max-length="100"
                    style="height:200px;"
                ></textarea>
            </label>
        </div>
        <div>
            <button
                class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline btn-default bg-red-500 text-white px-2 rounded"
                @click="edit=false" type="button">Cancel
            </button>
            <button type="button" wire:click="update({{$post->id}})" @click="edit=false"
                    class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-blue-600 text-white hover:bg-blue-600">
                Update
            </button>
        </div>
    </form>
</div>
