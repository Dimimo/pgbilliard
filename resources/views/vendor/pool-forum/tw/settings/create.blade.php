<x-layout>
    <div class="container mx-auto sm:px-4">
        <h1> Settings Create </h1>
        @if ($errors->any())
            <ul class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        @endif

        <form action="{{route('forum.settings.store')}}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="key">Key</label>
                <input class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                       type="text" name="key" id="key" value="{{old('key')}}" maxlength="100">
                @if($errors->has('key'))
                    <p class="text-red-600">{{$errors->first('key')}}</p>
                @endif
            </div>
            <div class="mb-4">

                <label for="value">Value</label>
                <input class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                       type="text" name="value" id="value" value="{{old('value')}}">
                @if($errors->has('value'))
                    <p class="text-red-600">{{$errors->first('value')}}</p>
                @endif
            </div>
            <div>
                <button
                    class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-blue-600 text-white hover:bg-blue-600"
                    type="submit">Create
                </button>
                <a href="{{route('forum.settings.index')}}">Back</a>
            </div>
        </form>

    </div>
</x-layout>
