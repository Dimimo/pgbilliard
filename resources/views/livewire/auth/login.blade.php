<div class="mx-auto">
    <form wire:submit="login" class="flex flex-col items-center">
        <!-- Email Address -->
        <div>
            <x-forms.input-label for="email" :value="__('Email')" />
            <x-forms.text-input
                wire:model="email"
                id="email"
                class="mt-1 block w-full"
                type="email"
                name="email"
                required
                autofocus
                autocomplete="username"
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
                type="{{$show_password ? 'text' : 'password'}}"
                name="password"
                required
                autocomplete="current-password"
            />

            <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mt-4 block">
            <label for="remember" class="inline-flex items-center">
                <input
                    wire:model="remember"
                    id="remember"
                    type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    name="remember"
                />
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Show/Hide Password -->
        <div class="mt-4 block">
            <label for="show_password" class="inline-flex items-center">
                <input
                    id="show_password"
                    type="checkbox"
                    wire:change="toggle_password()"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    name="show_password"
                />
                <span class="ml-2 text-sm text-gray-600">{{ __('Show/Hide password') }}</span>
            </label>
        </div>

        <div class="mt-4 flex items-center justify-end">
            @if (Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    wire:navigate
                >
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-forms.primary-button class="ml-3">
                {{ __('Log in') }}
            </x-forms.primary-button>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="my-4" :status="session('status')" />
    </form>
</div>
