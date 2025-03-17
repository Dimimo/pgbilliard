@props(['limit' => 255, 'value' => '', 'for', 'css_error' => ''])

<div
    x-data="{
        content: `{{ $value }}`,
        limit: {{ $limit }},
        get remaining() {
            return this.limit - this.content.length
        }
    }"
>
    <label>
        <textarea
            x-model="content"
            maxlength="{{ $limit }}"
            id="{{ $for }}"
            rows="8"
            {{ $attributes->merge(['class' => "mx-auto mb-2 block w-full rounded-lg border-2 border-indigo-800 p-4 focus:border-transparent" . $css_error]) }}
        ></textarea>
    </label>

    <div class="-mt-2 flex justify-between text-sm">
        <div>
            @error($for)
            <div class="text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div class="italic text-gray-700">
            <span x-text="remaining"></span> characters remaining
        </div>
    </div>
</div>

