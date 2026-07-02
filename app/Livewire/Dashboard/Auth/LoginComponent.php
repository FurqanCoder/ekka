<?php

namespace App\Livewire\Dashboard\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginComponent extends Component
{
     public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            // Authentication passed
            session()->regenerate();
            return redirect()->intended(route('dashboard')); // change to your dashboard route
        }

        $this->addError('email', 'These credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.dashboard.auth.login-component')->extends('layouts.authLayout')->section('dev-content');;
    }
}
