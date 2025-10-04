<div>
    <table class="mb-5 min-w-full table-auto bg-white">
        <thead class="whitespace-nowrap">
            <tr>
                <th class="bg-gray-200 p-2 text-left text-gray-900">Name</th>
                <th class="bg-gray-200 p-2 text-left text-gray-900">Assigned by</th>
                <th class="bg-gray-200 p-2 text-left text-gray-900">Since</th>
                <th class="bg-gray-200 p-2"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
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
                        @if (!$admin->super_admin && (auth()->user()->isSuperAdmin() || $admin->assigned_by === auth()->user()->id))
                            <button
                                type="button"
                                title="Remove this administrator"
                                wire:click="removeAdmin({{ $admin->user_id }})"
                                wire:confirm="Do you want to remove this user as an administrator?"
                            >
                                <x-svg.user-minus-solid
                                    color="fill-red-500"
                                    size="6"
                                    padding="mb-1"
                                />
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mb-4 flex h-8 w-full justify-center">
        <x-forms.spinner />
        <x-forms.action-message class="mx-3 text-red-700" on="admin-removed">
            Removed!
        </x-forms.action-message>
        <x-forms.action-message class="mx-3 text-green-700" on="admin-added">
            Added!
        </x-forms.action-message>
    </div>

    <x-forms.sub-title title="Add another admin">
        <div class="grid grid-cols-2">
            <div class="p-2 text-right text-xl">Select a user</div>
            <div class="p-2">
                <label for="user_id"></label>
                <select id="user_id" wire:model.change="user_id">
                    <option>-- admin select --</option>
                    @foreach (array_diff_key($users, array_flip($adminIds)) as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div
            class="m-2 flex flex-col space-y-2 rounded-lg border border-green-500 bg-green-100 p-4 text-green-700"
        >
            <p>
                <u>It goes without saying</u>
                :
                <strong>please be careful</strong>
                who you choose to become an administrator. They have the same powers as you! To
                remove an admin, simply click
                <x-svg.user-minus-solid color="fill-red-500" size="4" padding="mb-1" />
            </p>
            <p>
                No emails are send
                <u>to the selected user</u>
                about the admin state. Making a mistake goes quiet 🤫, although, an email is sent to
                the shared Admin inbox to advice all admins. If you make a mistake, simply delete
                them from the inbox.
            </p>
            <p>
                <u class="font-bold">Fun fact</u>
                : you can accidentally remove yourself... and you can't undo it! You have to confirm
                the action though. Don't worry.
            </p>
            <p>
                For practical reasons, you can't remove the Administrator (user id 1). Because, at
                least one person
                <strong>needs</strong>
                to be an admin...
            </p>
        </div>
    </x-forms.sub-title>
</div>
