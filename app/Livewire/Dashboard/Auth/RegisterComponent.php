<?php

namespace App\Livewire\Dashboard\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterComponent extends Component
{
    public $name;
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'name'     => 'required|string|min:3|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Auto-login the user after register
        Auth::login($user, $this->remember);

        // Redirect somewhere
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.dashboard.auth.register-component')->extends('layouts.authLayout')->section('dev-content');
    }
}
