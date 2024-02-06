<x-layout>
    <div class="container mx-auto sm:px-4">
        <h1> Edit Discussion </h1>
        @if ($errors->any())
            <ul class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif


        <form action="{{route('forum.discussions.update',['discussion'=>$discussion])}}" method="POST" id="form">
            @method('PUT')
            @csrf
            <div class="mb-4">
                <label for="title">Title</label>
                <input class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                       type="text" name="title" id="title" value="{{old('title', $discussion->title)}}" maxlength="200">
                @if($errors->has('title'))
                    <p class="text-red-600">{{$errors->first('title')}}</p>
                @endif
            </div>
            <div class="mb-4">
                <div class="relative block mb-2 inline-block mr-2">
                    <input class="absolute mt-1 -ml-6" name="is_private" type="checkbox" id="is_private" boolean
                           value="{{old('is_private',  $discussion->is_private)}}">
                    <label class="text-gray-700 pl-6 mb-0" for="is_private">private </label>
                </div>
                <div class="relative block mb-2 inline-block mr-2">
                    <input class="absolute mt-1 -ml-6" name="is_approved" type="checkbox" id="is_approved" boolean
                           value="{{old('is_approved',  $discussion->is_approved)}}">
                    <label class="text-gray-700 pl-6 mb-0" for="is_approved">approved </label>
                </div>
                <div class="relative block mb-2 inline-block mr-2">
                    <input class="absolute mt-1 -ml-6" name="is_locked" type="checkbox" id="is_locked" boolean
                           value="{{old('is_locked', $discussion->is_locked)}}">
                    <label class="text-gray-700 pl-6 mb-0" for="is_locked">locked </label>
                </div>
                <div class="relative block mb-2 inline-block mr-2">
                    <input class="absolute mt-1 -ml-6" name="is_sticky" type="checkbox" id="is_sticky" boolean
                           value="{{old('is_sticky', $discussion->is_sticky)}}">
                    <label class="text-gray-700 pl-6 mb-0" for="is_sticky">sticky </label>
                </div>
            </div>
            <div class="mb-4">
                <h2>
                    Tags (
                    <span id="tag-counter">
                    {{ is_array(old('tags')) ? count(old('tags')) : 0 }}
                </span>
                    )
                </h2>
            </div>
            <div class="mb-4">
                @foreach($tags as $tag)
                    <span class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded"
                          style="color:{{$tag->color}};background-color:{{$tag->background_color}};">
                <div class="relative block mb-2 inline-block mr-2">
                    <input class="absolute mt-1 -ml-6" name="tags[{{$tag->id}}]" tag-checkbox type="checkbox" id="tags-{{$tag->id}}"
                           {{isset($discussionTags[$tag->id]) ? 'checked="checked"' : ''}} value="{{$tag->id}}" onclick="count_tags()">
                    <label class="text-gray-700 pl-6 mb-0" for="tags-{{$tag->id}}">{{$tag->name}}</label>
                </div>
            </span>
                @endforeach
            </div>

            <div>
                <button
                    class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-blue-600 text-white hover:bg-blue-600"
                    type="submit">Save
                </button>
                <a href="{{route('forum.discussions.index')}}">Back</a>
            </div>

        </form>
    </div>

    <script type="text/javascript">

        function count_tags() {
            const el = document.querySelectorAll('#form input[type=checkbox][tag-checkbox]');
            let count = 0;

            for (let i = 0; i < el.length; i++) {
                if (el[i].checked === true) {
                    count++;
                }
            }
            document.getElementById('tag-counter').innerHTML = count.toString();
        }

        count_tags();
    </script>
</x-layout>
