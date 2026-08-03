<!-- resources/views/livewire/web/dashboard/user-profile.blade.php -->
<div>
    <div class="row g-4">
        <!-- Profile Information -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fa-solid fa-user me-2 text-primary"></i> Profile Information
                    </h6>
                    
                    <!-- Social Login Badge -->
                    @if($isSocialLogin)
                        <div class="alert alert-info mb-3">
                            <i class="fa-solid fa-info-circle me-2"></i>
                            You are logged in via <strong>{{ ucfirst($provider_name ?? 'Social') }}</strong>
                        </div>
                    @endif
                    
                    <form wire:submit.prevent="updateProfile">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   wire:model="name" placeholder="Enter your full name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   wire:model="email" placeholder="Enter your email">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Member Since</label>
                            <input type="text" class="form-control" 
                                   value="{{ auth()->user()->created_at->format('F d, Y') }}" disabled>
                        </div>
                        
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fa-solid fa-save me-1"></i> Update Profile
                        </button>
                        
                        @if($isSocialLogin)
                            <button type="button" class="btn btn-outline-danger px-4 ms-2" 
                                    wire:click="disconnectSocialLogin"
                                    onclick="return confirm('Are you sure you want to disconnect social login? You will need to use email/password to login.')">
                                <i class="fa-solid fa-link-slash me-1"></i> Disconnect Social Login
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">
                            <i class="fa-solid fa-lock me-2 text-primary"></i> 
                            {{ $isSocialLogin && !$hasPassword ? 'Set Password' : 'Change Password' }}
                        </h6>
                        <button class="btn btn-sm btn-outline-primary" wire:click="$set('showPasswordForm', !showPasswordForm)">
                            <i class="fa-solid fa-chevron-{{ $showPasswordForm ? 'up' : 'down' }}"></i>
                        </button>
                    </div>
                    
                    @if($isSocialLogin && !$hasPassword)
                        <div class="alert alert-warning mb-3">
                            <i class="fa-solid fa-exclamation-triangle me-2"></i>
                            You are using social login. Set a password to also login with email/password.
                        </div>
                    @endif
                    
                    @if($showPasswordForm)
                        <form wire:submit.prevent="updatePassword">
                            @if(!$isSocialLogin || $hasPassword)
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Current Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           wire:model="current_password" placeholder="Enter current password">
                                    @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    {{ $isSocialLogin && !$hasPassword ? 'New Password' : 'New Password' }} <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                       wire:model="new_password" placeholder="Enter new password (min 8 characters)">
                                @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Password must be at least 8 characters</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Confirm New Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                                       wire:model="new_password_confirmation" placeholder="Confirm new password">
                                @error('new_password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fa-solid fa-key me-1"></i> 
                                    {{ $isSocialLogin && !$hasPassword ? 'Set Password' : 'Update Password' }}
                                </button>
                                <button type="button" class="btn btn-secondary px-4" wire:click="$set('showPasswordForm', false)">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <i class="fa-solid fa-shield-halved fa-2x text-muted mb-2"></i>
                            @if($isSocialLogin && !$hasPassword)
                                <p class="text-muted small mb-2">You haven't set a password yet</p>
                                <p class="text-muted small mb-3">You can set a password to login with email</p>
                            @else
                                <p class="text-muted small mb-0">Your password is encrypted and secure</p>
                            @endif
                            <button class="btn btn-sm btn-outline-primary mt-2" wire:click="$set('showPasswordForm', true)">
                                <i class="fa-solid fa-pen me-1"></i> 
                                {{ $isSocialLogin && !$hasPassword ? 'Set Password' : 'Change Password' }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Account Statistics -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fa-solid fa-chart-simple me-2 text-primary"></i> Account Statistics
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="stat-item text-center p-3 bg-light rounded-3">
                                <h5 class="fw-bold text-primary mb-0">{{ $stats['total_orders'] }}</h5>
                                <small class="text-muted">Total Orders</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-item text-center p-3 bg-light rounded-3">
                                <h5 class="fw-bold text-success mb-0">{{ $stats['total_addresses'] }}</h5>
                                <small class="text-muted">Saved Addresses</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-item text-center p-3 bg-light rounded-3">
                                <h5 class="fw-bold text-warning mb-0">{{ $stats['total_wishlist'] }}</h5>
                                <small class="text-muted">Wishlist Items</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-item text-center p-3 bg-light rounded-3">
                                <h5 class="fw-bold text-danger mb-0">Rs. {{ number_format($stats['total_spent'], 0) }}</h5>
                                <small class="text-muted">Total Spent</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .stat-item {
            transition: transform 0.3s ease;
        }
        .stat-item:hover {
            transform: translateY(-3px);
        }
        
        .alert-info {
            background-color: #e8f0fe;
            border-color: #b3d4fc;
            color: #1a56db;
        }
        
        .alert-warning {
            background-color: #fef3c7;
            border-color: #fcd34d;
            color: #92400e;
        }
    </style>
</div>