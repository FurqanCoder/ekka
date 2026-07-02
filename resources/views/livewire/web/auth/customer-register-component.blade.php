<div>
    <div class="modal fade" id="signup" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content auth-modal">
                <button type="button" class="btn-close qty_close" data-bs-dismiss="modal"
    aria-label="Close" @if(!Auth::check()) disabled style="pointer-events:none; opacity:0.5;" @endif></button>

                <div class="modal-body">
                    <div class="row">
                        <!-- Left Side (optional image / promo) -->
                        <div class="col-md-5 d-none d-md-block">
                            <div class="auth-side-img">
                                <img class="img-fluid" src="web/images/login-side.jpg" alt="Signup">
                            </div>
                        </div>

                        <!-- Right Side (Signup Form) -->
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
                                        @error('passowrd')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Signup</button>
                                </form>

                                <!-- Divider -->
                                <div class="auth-divider">
                                    <span>OR</span>
                                </div>

                                <!-- Google Signup -->
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
    {{-- login --}}
    <div class="modal fade" id="login" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content auth-modal">
                <button type="button" class="btn-close qty_close" data-bs-dismiss="modal"
    aria-label="Close" @if(!Auth::check()) disabled style="pointer-events:none; opacity:0.5;" @endif></button>

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
                                <p class="mb-3">Login to your account</p>

                                <form wire:submit.prevent="login">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <input type="email" class="form-control"
                                            wire:model="email @error('email') is-invalid @enderror" name="email"
                                            placeholder="Email Address" required>
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
    Don’t have an account?
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
{{-- <script>
    window.addEventListener('close-register', () => {
        // console.log('close event worker started');
        const modal = bootstrap.Modal.getInstance(document.getElementById('signup'));
        modal.hide();
    });
    window.addEventListener('close-login', () => {
        // console.log('close event worker started');
        const modal = bootstrap.Modal.getInstance(document.getElementById('login'));
        modal.hide();
    });
</script> --}}
