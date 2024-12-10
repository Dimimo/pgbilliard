@props(['room', 'users'])

@foreach($users as $user)
    <li class='py-2.5 px-4 hover:bg-blue-50 text-black text-sm cursor-pointer' wire:key="{{ $user->id }}">
        <div class="flex items-center">
            <input
                id="user[{{ $user->id }}]"
                type="checkbox"
                class="hidden peer"
                wire:change="toggleUser({{ $user->id }})"
            />
            <div wire:loading wire:target="toggleUser({{ $user->id }})">
                <x-forms.spinner/>
            </div>
            <label
                for="user[{{ $user->id }}]"
                wire:loading.remove
                wire:target="toggleUser({{ $user->id }})"
                class="relative mx-3 flex items-center justify-center p-1 peer-checked:before:hidden before:block before:absolute before:w-full before:h-full before:bg-white w-5 h-5 cursor-pointer bg-blue-600 border rounded overflow-hidden"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-full fill-white" viewBox="0 0 520 520">
                    <path
                        d="M79.423 240.755a47.529 47.529 0 0 0-36.737 77.522l120.73 147.894a43.136 43.136 0 0 0 36.066 16.009c14.654-.787 27.884-8.626 36.319-21.515L486.588 56.773a6.13 6.13 0 0 1 .128-.2c2.353-3.613 1.59-10.773-3.267-15.271a13.321 13.321 0 0 0-19.362 1.343q-.135.166-.278.327L210.887 328.736a10.961 10.961 0 0 1-15.585.843l-83.94-76.386a47.319 47.319 0 0 0-31.939-12.438z"
                        data-name="7-Check" data-original="#000000"/>
                </svg>
            </label>
            {{ $user->name }}
        </div>
    </li>
@endforeach
