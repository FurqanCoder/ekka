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
        $this->dispatch('switch-to-signup', force: $this->isCheckout);
    }

    public function showLogin()
    {
        $this->resetErrorBag();
        $this->dispatch('switch-to-login', force: $this->isCheckout);
    }

    public function forceLogin($returnUrl = null)
    {
        $this->isCheckout = true;
        $this->returnUrl = $returnUrl;
        $this->dispatch('switch-to-login', force: true);
    }

    public function closeModal()
    {
        // Don't allow closing a forced checkout login via the close button
        if ($this->isCheckout) {
            return;
        }

        $this->resetErrorBag();
        $this->reset(['name', 'email', 'password']);
        $this->dispatch('close-login');
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

        $this->reset(['name', 'email', 'password']);
        $this->dispatch('close-login');
        $this->dispatch('userLoggedIn');

        if ($this->isCheckout) {
            $url = $this->returnUrl ?? route('web-check-out');
            $this->isCheckout = false;
            $this->returnUrl = null;
            return redirect()->to($url);
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

            app(CartService::class)->mergeGuestCartWithUserCart($user->id);

            $guestItems = json_decode(Cookie::get('wishlist_items', '[]'), true);
            foreach ($guestItems as $productId) {
                Wishlist::firstOrCreate([
                    'user_id'    => auth()->id(),
                    'product_id' => $productId,
                ]);
            }
            Cookie::queue(Cookie::forget('wishlist_items'));

            $this->reset(['email', 'password']);
            $this->dispatch('close-login');
            $this->dispatch('userLoggedIn');

            if ($this->isCheckout) {
                $url = $this->returnUrl ?? route('web-check-out');
                $this->isCheckout = false;
                $this->returnUrl = null;
                return redirect()->to($url);
            }

            session()->flash('success', 'Login successful!');
            return;
        }

        $this->reset('password');
        $this->addError('email', 'These credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.web.auth.customer-register-component');
    }
}