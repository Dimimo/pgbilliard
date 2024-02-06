<x-layout>
    <div class="container mx-auto sm:px-4">
        <h1> Settings Show </h1>

        <div class="mb-4">
            <label for="key">Key</label>
            <p>{{$setting->key}}</p>
        </div>
        <div class="mb-4">
            <label for="value">Value</label>
            <p>{{$setting->value}}</p>
        </div>
        <a href="{{route('forum.settings.index')}}">Back</a>
    </div>
</x-layout>
