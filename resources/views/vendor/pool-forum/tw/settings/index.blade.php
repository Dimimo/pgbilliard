<x-layout>
    <div class="container mx-auto sm:px-4">

        @if (session('laravel-forum-status'))
            <div class="relative px-3 py-3 mb-4 border rounded bg-green-200 border-green-300 text-green-800">

                {{ session('laravel-forum-status') }}
            </div>
        @endif
        <h1> Settings </h1>
        <div>
            <a href="{{route('forum.settings.create')}}">New</a>
        </div>
        <table class="w-full max-w-full mb-4 bg-transparent table-striped">
            @if(count($settings))
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Key</th>
                    <th>Value</th>
                </tr>
                </thead>
            @endif
            <tbody>
            @forelse($settings as $setting)
                <tr>
                    <td>
                        <a href="{{route('forum.settings.show',['setting'=>$setting] )}}">Show</a>
                        <a href="{{route('forum.settings.edit',['setting'=>$setting] )}}">Edit</a>
                        <a href="javascript:void(0)" onclick="preventDefault();
                    document.getElementById('delete-setting-{{$setting->id}}').submit();">
                            {{ __('Delete') }}
                        </a>
                        <form id="delete-setting-{{$setting->id}}" action="{{ route('forum.settings.destroy',['setting'=>$setting]) }}" method="POST"
                              style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                    <td>{{ $setting->key }}</td>
                    <td>{{ $setting->value   }}</td>
                </tr>
            @empty
                <p>No settings</p>
            @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
