<x-layout>
    <div class="container mx-auto sm:px-4 posts">
        <div class="flex flex-wrap  py-3 my-3 border-b border-color-secondary">
            <div class="col-auto">
                <a href="{{route('forum.discussions.index')}}" class="h1 text-gray-600">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </div>
            <div class="relative flex-grow max-w-full flex-1 px-4  text-center">
                <h1 class="text-gray-600">{{$discussion->title}}</h1>
                @foreach($discussion->tags as $tag)
                    <span
                        class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded"
                        style="color:{{$tag->color}};background-color:{{$tag->background_color}};">
                {{$tag->name}}
            </span>
                @endforeach
            </div>
        </div>
        @if (session('laravel-forum-status'))
            <div class="relative px-3 py-3 mb-4 border rounded bg-green-200 border-green-300 text-green-800">

                {{ session('laravel-forum-status') }}
            </div>
        @endif

        @livewire('forum.comments', ['discussion'=>$discussion,'posts' => $posts])

        <div class="flex flex-wrap  py-3 my-3">
            @if(!$discussion->is_locked)
                @livewire('forum.comment', ['discussion' => $discussion,'user'=>Auth::user()->name])
            @else
                <div class="relative flex-grow max-w-full flex-1 px-4 text-center text-gray-700">
                    Discussion locked by owner
                </div>
            @endif
        </div>
    </div>

    <script type="text/javascript">
        function toggleEdit(postId) {
            const content = document.getElementById('post-content-' + postId);
            const form = document.getElementById('post-form-' + postId);

            const addContent = document.getElementById('post-content');
            const addSubmit = document.querySelectorAll('#post-form [type=submit]')[0];

            if (form.classList.contains('d-none')) {
                content.classList.remove('d-block');
                content.classList.add('d-none');
                form.classList.remove('d-none');
                form.classList.add('d-block');
                addContent.disabled = true;
                addSubmit.disabled = true;
            } else {
                content.classList.remove('d-none');
                content.classList.add('d-block');
                form.classList.remove('d-block');
                form.classList.add('d-none');
                addContent.disabled = false;
                addSubmit.disabled = false;
            }
        }

        function canEdit(postId) {
            const submit = document.querySelectorAll('#post-form-' + postId + ' [type=submit]')[0];
            const textarea = document.querySelectorAll('#post-form-' + postId + ' [name=content]')[0];
            const data = textarea.value.trim();
            const old = textarea.getAttribute('old').trim();

            submit.disabled = !(data.length > 0 && data !== old);
        }
    </script>
</x-layout>
