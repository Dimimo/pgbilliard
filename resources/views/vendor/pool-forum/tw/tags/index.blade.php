<x-layout>
    <div class="container mx-auto sm:px-4">

        @if (session('laravel-forum-status'))
            <div class="relative px-3 py-3 mb-4 border rounded bg-green-200 border-green-300 text-green-800">

                {{ session('laravel-forum-status') }}
            </div>
        @endif
        <h1> Tags </h1>
        <div>
            <a href="{{route('forum.tags.create')}}">New</a>
        </div>
        <table class="w-full max-w-full mb-4 bg-transparent table-striped">
            @if(count($tags))
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Name</th>
                    <th>Slug</th>
                </tr>
                </thead>
            @endif
            <tbody>
            @forelse($tags as $tag)
                <tr>
                    <td>
                        <a href="{{route('forum.tags.show',['tag'=>$tag] )}}">Show</a>
                        <a href="{{route('forum.tags.edit',['tag'=>$tag] )}}">Edit</a>
                        <a href="javascript:void(0)" onclick="preventDefault();
                    document.getElementById('delete-tag-{{$tag->id}}').submit();">
                            {{ __('Delete') }}
                        </a>
                        <form id="delete-tag-{{$tag->id}}" action="{{ route('forum.tags.destroy',['tag'=>$tag]) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                    <td><span class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded"
                              style="color:{{$tag->color}};background:{{$tag->background_color}}">
                        {{ $tag->name }}
                    </span>
                    </td>
                    <td>{{ $tag->slug   }}</td>
                </tr>
            @empty
                <p>No tags</p>
            @endforelse
            </tbody>
        </table>

    </div>

</x-layout>
