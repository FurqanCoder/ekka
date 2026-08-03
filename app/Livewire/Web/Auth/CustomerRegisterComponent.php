<?php

namespace App\Livewire\Web\Auth;

use App\Models\User;
use App\Models\Wishlist;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CustomerRegisterComponent extends Component
{
    public $name;
    public $email;
    public $password;
    public $isCheckout = false; // Flag for checkout forced login
    public $returnUrl = null;

    protected $listeners = [
        'showSignup' => 'showSignup',
        'showLogin'  => 'showLogin',
        'forceLogin' => 'forceLogin',
    ];

    protected $rules = [
        'name'     => 'required|string|min:3|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ];

    public function showSignup()
    {
        $this->resetErrorBag();
        $this->dispatch('switch-to-signup');
    }

    public function showLogin()
    {
        $this->resetErrorBag();
        $this->dispatch('switch-to-login');
    }

    public function forceLogin($returnUrl = null)
    {
        $this->isCheckout = true;
        $this->returnUrl = $returnUrl;
        $this->dispatch('switch-to-login');
    }

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->assignRole('customer');
        session()->regenerate();
        Auth::login($user);
        app(CartService::class)->mergeGuestCartWithUserCart($user->id);

        // Close modal
        $this->dispatch('close-login');
        $this->dispatch('userLoggedIn');

        // For checkout, redirect back
        if ($this->isCheckout) {
            return redirect()->route('web-check-out');
        }

        session()->flash('success', 'Account created and logged in successfully!');
    }

    public function login()
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            $user = Auth::user();

            // Merge guest cart
            app(CartService::class)->mergeGuestCartWithUserCart($user->id);

            // Merge guest wishlist
            $guestItems = json_decode(Cookie::get('wishlist_items', '[]'), true);
            foreach ($guestItems as $productId) {
                Wishlist::firstOrCreate([
                    'user_id' => auth()->id(),
                    'product_id' => $productId,
                ]);
            }
            Cookie::queue(Cookie::forget('wishlist_items'));

            $this->dispatch('close-login');
            $this->dispatch('userLoggedIn');

            // For checkout, redirect back
            if ($this->isCheckout) {
                return redirect()->route('web-check-out');
            }

            session()->flash('success', 'Login successful!');
            return;
        }

        $this->addError('email', 'These credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.web.auth.customer-register-component');
    }
}