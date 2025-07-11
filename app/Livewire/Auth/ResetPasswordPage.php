<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Reset Password')]
class ResetPasswordPage extends Component
{
    public $token;
    #[Url()]
    public $email;
    public $password;
    public $password_confirmation;

    public function mount($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function save()
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $status = Password::reset([
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token,
        ], function (User $user, string $password) {
            $password = $this->password;
            $user->forceFill([
                'password' => Hash::make($password),
            ])->setRememberToken(Str::random(60));
            $user->save();

            event(new PasswordReset($user));
        });

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
