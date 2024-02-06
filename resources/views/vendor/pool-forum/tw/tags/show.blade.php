<x-layout>
    <div class="container mx-auto sm:px-4">
        <h1> Show Tag </h1>

        <div class="mb-4">
            <label for="key">Name</label>
            <p>{{$tag->name}}</p>
        </div>
        <div class="mb-4">
            <label for="slug">Slug</label>
            <p>{{$tag->slug}}</p>
        </div>

        <div class="mb-4">
            <label for="color">Color</label>
            <p>{{$tag->color}}</p>
        </div>

        <div class="mb-4">
            <label for="background_color">Background color</label>
            <p>{{$tag->background_color}}</p>
        </div>
        <div class="mb-4">
            <label for="demo">Demo</label>
            <p>
            <span class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded"
                  style="color:{{$tag->color}};background:{{$tag->background_color}}">
                {{ $tag->name }}
            </span>
            </p>
        </div>

        <a href="{{route('forum.tags.index')}}">Back</a>
    </div>
</x-layout>
