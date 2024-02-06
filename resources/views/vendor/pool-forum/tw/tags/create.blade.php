<x-layout>
    <div class="container mx-auto sm:px-4">
        <h1> Create Tag </h1>
        @if ($errors->any())
            <ul class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{route('forum.tags.store')}}" method="POST" id="form">
            @csrf
            <div class="mb-4">
                <label for="name">Name</label>
                <input class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                       type="text"
                       name="name"
                       id="name"
                       value="{{old('name')}}"
                       maxlength="100">
                @if($errors->has('name'))
                    <p class="text-red-600">{{$errors->first('name')}}</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="description">Description</label>
                <textarea class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                          type="text" name="description" id="description" max-length="500">{{old('description')}}</textarea>
                @if($errors->has('description'))
                    <p class="text-red-600">{{$errors->first('description')}}</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="color">Color</label>
                <input
                    class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                    type="color"
                    name="color"
                    id="color"
                    value="{{old('color', '#ffffff')}}"
                    max-length="50">
                @if($errors->has('color'))
                    <p class="text-red-600">{{$errors->first('color')}}</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="background_color">Background Color</label>
                <input class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                       type="color"
                       name="background_color"
                       id="background_color"
                       value="{{old('background_color', '#222222')}}"
                       max-length="100">
                @if($errors->has('background_color'))
                    <p class="text-red-600">{{$errors->first('background_color')}}</p>
                @endif
            </div>


            <div>
                <button
                    class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-blue-600 text-white hover:bg-blue-600"
                    type="submit">Create
                </button>
                <a href="{{route('forum.tags.index')}}">Back</a>
            </div>
        </form>
    </div>

</x-layout>
