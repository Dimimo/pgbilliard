<div>
    <table class="table-auto min-w-full bg-white mb-5">
        <thead class="whitespace-nowrap">
        <tr>
            <th class="p-2 text-left bg-gray-200 text-gray-900">Name</th>
            <th class="p-2 text-left bg-gray-200 text-gray-900">Assigned by</th>
            <th class="p-2 text-left bg-gray-200 text-gray-900">Since</th>
            <th class="p-2 bg-gray-200"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($admins as $admin)

            <tr class="whitespace-nowrap" wire:key="{{ $admin->id }}">
                <td class="p-2 text-left">
                    {{ $admin->user->name }}
                </td>
                <td class="p-2 text-left text-gray-700">
                    {{ $admin->assigned->name }}
                </td>
                <td>
                    {{ $admin->created_at->format('Y-m-d') }}
                </td>
                <td>
                    @if(!$admin->super_admin && (Auth::user()->isSuperAdmin() || $admin->assigned_by === Auth::user()->id))
                        <button
                            type="button"
                            wire:click="removeAdmin({{ $admin->user_id }})"
                            wire:confirm="Do you want to remove this user as an administrator?"
                        >
                            <img class="mx-auto" src="{{ secure_asset('svg/user-delete.svg') }}" alt="Remove" width="24" height="24">
                        </button>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="w-full flex justify-end mb-4 h-2">
        <x-spinner/>
        <x-action-message class="mx-3" on="admin-removed">
            Removed!
        </x-action-message>
        <x-action-message class="mx-3" on="admin-added">
            Added!
        </x-action-message>
    </div>

    <x-sub-title title="Add another admin">
        <div class="grid grid-cols-2">
            <div class="text-right p-2 text-xl">Select a user</div>
            <div class="p-2">
                <label for="user_id"></label>
                <select id="user_id" wire:model.change="user_id">
                    <option> -- admin select --</option>
                    @foreach(array_diff_key($users, array_flip($ids)) as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </x-sub-title>
</div>
