@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-xl text-gray-900']) }}>
    {{ $value ?? $slot }}
</label>
