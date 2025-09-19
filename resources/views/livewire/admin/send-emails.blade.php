<div>
    <label for="group">Send emails to all</label>
    <select
        class="mb-1 inline-block w-min appearance-none flex-nowrap rounded border border-gray-500 bg-white px-2 py-1 text-base leading-normal text-gray-800"
        id="group"
        wire:model.change="group"
    >
        <option value="">-- select --</option>
        @foreach ($choices as $i => $choice)
            <option value="{{ $choice }}" wire:key="choice-{{ $i }}">
                {{ $choice }}
            </option>
        @endforeach
    </select>

    @error('group')
        <div class="text-sm text-red-600">{{ $message }}</div>
    @enderror

    @if ($users)
        @if ($users->count())
            <div class="mb-2">{{ $users->count() }} {{ $group }} selected:</div>
            <ul class="list-inside list-disc">
                @foreach ($users as $user)
                    <li>{{ $user->name }}</li>
                @endforeach
            </ul>

            <form class="my-8 rounded-lg bg-indigo-50 p-4" wire:submit="send">
                @csrf
                <div class="grid justify-items-center">
                    <x-forms.input-label for="title">Title</x-forms.input-label>
                    <x-forms.text-input
                        id="title"
                        class="w-full md:w-3/4"
                        type="text"
                        wire:model="title"
                        :maxlength="\App\Constants::FORUM_TITLE"
                    />
                    <div>
                        @error('title')
                            <span class="text-red-700">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 grid justify-items-center">
                    <x-forms.input-label for="body">Your message</x-forms.input-label>
                    <div class="w-full">
                        <x-forms.textarea-constrained
                            for="body"
                            :value="$body"
                            :limit="\App\Constants::FORUM_BODY"
                        />
                    </div>
                </div>

                <div class="my-4">
                    <div class="text-center">
                        <x-forms.primary-button>Send emails!</x-forms.primary-button>
                    </div>
                </div>
            </form>
        @else
            <div class="text-red-700">
                You selection has no players in the current Season with a personal email
            </div>
        @endif
    @endif
</div>
