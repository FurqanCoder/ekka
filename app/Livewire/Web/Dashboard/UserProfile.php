<?php

namespace App\Livewire\Web\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserProfile extends Component
{
    public $name;
    public $email;
    public $avatar;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $showPasswordForm = false;
    public $stats = [];
    public $isSocialLogin = false;
    public $hasPassword = false;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->avatar = $user->avatar;
        $this->isSocialLogin = $user->isSocialLogin();
        $this->hasPassword = $user->hasPassword();
        $this->loadStats();
    }

    public function loadStats()
    {
        $user = Auth::user();
        $this->stats = [
            'total_orders' => $user->orders()->count(),
            'total_addresses' => $user->addresses()->count(),
            'total_wishlist' => $user->wishlist()->count(),
            'total_spent' => $user->orders()->sum('grand_total'),
        ];
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(Auth::id()),
            ],
        ]);

        Auth::user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Profile updated successfully!']);
    }

    public function updatePassword()
    {
        $user = Auth::user();

        // For social login users without password
        if ($this->isSocialLogin && !$this->hasPassword) {
            // Social login users can set a new password without current password
            $this->validate([
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            $user->update([
                'password' => Hash::make($this->new_password),
            ]);

            $this->new_password = '';
            $this->new_password_confirmation = '';
            $this->showPasswordForm = false;

            $this->dispatch('notify', ['type' => 'success', 'message' => 'Password set successfully! You can now login with your email and password.']);
            return;
        }

        // For regular users with password
        $this->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Current password is incorrect.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
        $this->showPasswordForm = false;

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Password updated successfully!']);
    }

    public function disconnectSocialLogin()
    {
        $user = Auth::user();
        
        // Only allow if user has a password set
        if (!$user->hasPassword()) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Please set a password first before disconnecting social login.']);
            return;
        }

        $user->update([
            'provider_id' => null,
            'provider_name' => null,
        ]);

        $this->isSocialLogin = false;
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Social login disconnected successfully.']);
    }

    public function render()
    {
        return view('livewire.web.dashboard.user-profile');
    }
}