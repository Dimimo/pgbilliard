<div class="border-t border-gray-200 pt-4 pb-1">
    <div class="px-4">
        <div class="text-sm font-medium text-gray-800">Log In / Register</div>
    </div>

    <div class="mt-3 space-y-1">
        <x-forms.responsive-nav-link :href="route('login')" wire:navigate>
            {{ __('Log in') }}
        </x-forms.responsive-nav-link>

        <x-forms.responsive-nav-link :href="route('players.accounts')" wire:navigate>
            {{ __('Claim your account') }}
        </x-forms.responsive-nav-link>

        <x-forms.responsive-nav-link :href="route('register')" wire:navigate>
            {{ __('Register') }}
        </x-forms.responsive-nav-link>
    </div>
</div>
