<div class="mx-auto">
    <form wire:submit="register" class="flex flex-col items-center">
        <div class="my-8 px-4 py-2">
            Before you register, please
            <a
                href="{{ route('players.accounts') }}"
                class="border border-transparent font-semibold text-blue-700 hover:border hover:border-blue-700 hover:bg-blue-100"
                wire:navigate
            >
                check if your name can not be claimed first!
            </a>
        </div>
        <!-- Name -->
        <div>
            <x-forms.input-label for="name" :value="__('Name')" />
            <x-forms.text-input
                wire:model="name"
                id="name"
                class="mt-1 block w-full"
                type="text"
                name="name"
                required
                autofocus
                autocomplete="name"
            />
            <x-forms.input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Contact Number -->
        <div class="mt-4">
            <x-forms.input-label for="contact_nr">
                Contact Number
                <span class="text-sm text-gray-700">(optional)</span>
            </x-forms.input-label>
            <x-forms.text-input
                wire:model="contact_nr"
                id="contact_nr"
                class="mt-1 block w-full"
                type="text"
                name="contact_nr"
                autofocus
                autocomplete="contact_nr"
            />
            <x-forms.input-error :messages="$errors->get('contact_nr')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-forms.input-label for="email" :value="__('Email')" />
            <x-forms.text-input
                wire:model="email"
                id="email"
                class="mt-1 block w-full"
                type="email"
                name="email"
                required
                autocomplete="email"
            />
            <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-forms.input-label for="password" :value="__('Password')" />

            <x-forms.text-input
                wire:model="password"
                id="password"
                class="mt-1 block w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />

            <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-forms.input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-forms.text-input
                wire:model="password_confirmation"
                id="password_confirmation"
                class="mt-1 block w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <x-forms.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4 flex items-center justify-end">
            <a
                href="{{ route('login') }}"
                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                wire:navigate
            >
                {{ __('Already registered?') }}
            </a>

            <x-forms.primary-button class="ml-4">
                {{ __('Register') }}
            </x-forms.primary-button>
        </div>
    </form>
</div>
