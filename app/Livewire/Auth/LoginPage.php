<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login')]
class LoginPage extends Component
{
    public $email;
    public $password;

    public function save()
    {
        $this->validate([
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|min:6|max:255',
        ]);

        if (!Auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('error', 'These credentials do not match our records.');
            return;
        }

        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
