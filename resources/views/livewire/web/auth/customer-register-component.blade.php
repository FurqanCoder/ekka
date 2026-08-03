<div>
    <!-- Signup Modal -->
    <div class="modal fade" id="signup" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content auth-modal">
                <button type="button" class="btn-close qty_close" data-bs-dismiss="modal"
                    aria-label="Close" id="signup-close-btn" style="display: none;"></button>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 d-none d-md-block">
                            <div class="auth-side-img">
                                <img class="img-fluid" src="web/images/login-side.jpg" alt="Signup">
                            </div>
                        </div>

                        <div class="col-md-7 col-sm-12">
                            <div class="auth-content">
                                <h4 class="ec-title">Create Account</h4>
                                <p class="mb-3">Signup to get started with our store.</p>

                                <form wire:submit.prevent="register">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" placeholder="Full Name" wire:model="name" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" placeholder="Email Address" wire:model="email" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            wire:model="password" name="password" placeholder="Password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Signup</button>
                                </form>

                                <div class="auth-divider">
                                    <span>OR</span>
                                </div>

                                <a href="{{ route('google.login') }}" class="btn btn-danger w-100 mb-3">
                                    <i class="fab fa-google me-2"></i> Sign up with Google
                                </a>

                                <p class="text-center">
                                    Already have an account?
                                    <a href="#" wire:click.prevent="showLogin">Login</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="login" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content auth-modal">
                <button type="button" class="btn-close qty_close" data-bs-dismiss="modal"
                    aria-label="Close" id="login-close-btn" style="display: none;"></button>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 d-none d-md-block">
                            <div class="auth-side-img">
                                <img class="img-fluid" src="web/images/login-side.jpg" alt="Login">
                            </div>
                        </div>

                        <div class="col-md-7 col-sm-12">
                            <div class="auth-content">
                                <h4 class="ec-title">Welcome Back</h4>
                                <p class="mb-3">Login to your account to continue</p>

                                <form wire:submit.prevent="login">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            wire:model="email" name="email" placeholder="Email Address" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            wire:model="password" name="password" placeholder="Password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Login</button>
                                </form>

                                <div class="auth-divider">
                                    <span>OR</span>
                                </div>

                                <a href="{{ route('google.login') }}" class="btn btn-danger w-100 mb-3">
                                    <i class="fab fa-google me-2"></i> Login with Google
                                </a>

                                <p class="text-center">
                                    Don't have an account?
                                    <a href="#" wire:click.prevent="showSignup">Signup</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Modal control
    window.addEventListener('switch-to-signup', () => {
        const modalEl = document.getElementById('signup');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        
        // Remove backdrop static to prevent closing on outside click
        modalEl.setAttribute('data-bs-backdrop', 'static');
        modalEl.setAttribute('data-bs-keyboard', 'false');
        
        modal.show();
    });

    window.addEventListener('switch-to-login', () => {
        const modalEl = document.getElementById('login');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        
        // Remove backdrop static to prevent closing on outside click
        modalEl.setAttribute('data-bs-backdrop', 'static');
        modalEl.setAttribute('data-bs-keyboard', 'false');
        
        modal.show();
    });

    window.addEventListener('close-login', () => {
        // Close signup modal
        const signupModal = bootstrap.Modal.getInstance(document.getElementById('signup'));
        if (signupModal) {
            signupModal.hide();
        }
        
        // Close login modal
        const loginModal = bootstrap.Modal.getInstance(document.getElementById('login'));
        if (loginModal) {
            loginModal.hide();
        }
    });
    // Force login for checkout
window.addEventListener('force-login', (event) => {
    // Open login modal
    const loginModal = document.getElementById('login');
    if (loginModal) {
        const modal = bootstrap.Modal.getOrCreateInstance(loginModal);
        loginModal.setAttribute('data-bs-backdrop', 'static');
        loginModal.setAttribute('data-bs-keyboard', 'false');
        modal.show();
    }
});

// Listen for force-login event from Livewire
document.addEventListener('livewire:initialized', function () {
    Livewire.on('force-login', (data) => {
        const loginModal = document.getElementById('login');
        if (loginModal) {
            const modal = bootstrap.Modal.getOrCreateInstance(loginModal);
            loginModal.setAttribute('data-bs-backdrop', 'static');
            loginModal.setAttribute('data-bs-keyboard', 'false');
            modal.show();
        }
    });
    
    Livewire.on('close-login', () => {
        // Close both modals
        ['login', 'signup'].forEach(id => {
            const modalEl = document.getElementById(id);
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
            }
        });
    });
});
</script>