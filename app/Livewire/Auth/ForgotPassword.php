<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ForgotPassword extends Component
{
    public string $email = '';

    public function rules(): array
    {
        return ['email' => ['required', 'string', 'email']];
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.auth.forgot-password');
    }

    public function sendPasswordResetLink(): void
    {
        $this->validate();
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink($this->only('email'));
        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }
        $this->reset('email');
        session()->flash('status', __($status));
        Toaster::success(__($status));
    }
}
