<?php

namespace App\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    public bool $show_password = false;

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['boolean'],
            'show_password' => ['boolean'],
        ];
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.auth.login');
    }

    public function login(): void
    {
        $this->validate();
        $throttleKey = Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            event(new Lockout(request()));
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }
        if (!auth()->attempt($this->only(['email', 'password']), $this->remember)) {
            RateLimiter::hit($throttleKey);
            //$this->addError('credentials', 'Your credentials don\'t match our records');
            session()->flash('status', 'Your credentials don\'t match our records');
            //            throw ValidationException::withMessages([
            //                'email' => trans('auth.failed'),
            //            ]);
        } else {
            RateLimiter::clear($throttleKey);
            session()->regenerate();
            session(['last_login' => auth()->user()->updated_at]);
            session()->forget('my_team');
            auth()->user()->touch('updated_at');
            session()->flash('success', 'Welcome back ' . auth()->user()->name . '!');
            $this->redirect(session('url.intended', RouteServiceProvider::HOME));
        }
    }

    public function toggle_password(): void
    {
        $this->show_password = !$this->show_password;
    }
}
