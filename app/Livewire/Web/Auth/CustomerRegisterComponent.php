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
    public $password; // ✅ fixed typo (was passwword)

    protected $rules = [
        'name'     => 'required|string|min:3|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ];

    /**
     * Show Signup Modal
     */
    public function showSignup()
    {
        $this->dispatch('switch-to-signup');
    }

    /**
     * Show Login Modal
     */
    public function showLogin()
    {
        $this->dispatch('switch-to-login');
    }

    /**
     * Handle User Registration
     */
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
        // Auto-login the new user
        Auth::login($user);
        app(\App\Services\CartService::class)->mergeGuestCartWithUserCart($user->id);


        // 🔥 Merge guest cart to DB after login
        // app(CartService::class)->mergeSessionToDatabase();

        // Close signup modal and refresh page/cart
        $this->dispatch('close-login'); // if you use same modal for both login/signup
        $this->dispatch('userLoggedIn');
        $this->dispatch('$refresh');

        session()->flash('success', 'Account created and logged in successfully!');
    }

    /**
     * Handle User Login
     */
   public function login()
{
    $this->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
        // Regenerate session to prevent fixation
        session()->regenerate();

        // ✅ Get logged-in user
        $user = Auth::user();

        // ✅ Transfer guest cart (cookie) into database
        app(\App\Services\CartService::class)->mergeGuestCartWithUserCart($user->id);
        $guestItems = json_decode(Cookie::get('wishlist_items', '[]'), true);

foreach ($guestItems as $productId) {
    Wishlist::firstOrCreate([
        'user_id' => auth()->id(),
        'product_id' => $productId,
    ]);
}

Cookie::queue(Cookie::forget('wishlist_items'));


        // ✅ Fire Livewire browser events
        $this->dispatch('close-login');
        $this->dispatch('userLoggedIn');
        $this->dispatch('$refresh');

        session()->flash('success', 'Login successful!');
        return;
    }

    // ❌ Wrong credentials
    $this->addError('email', 'These credentials do not match our records.');
}


    public function render()
    {
        return view('livewire.web.auth.customer-register-component');
    }
}
