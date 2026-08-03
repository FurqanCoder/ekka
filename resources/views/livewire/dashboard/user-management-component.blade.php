<div>
    <div class="body-wrapper">
        <div class="container-fluid">
            <!-- Header -->
            <div class="card card-body py-3 mb-4">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                            <h4 class="mb-4 mb-sm-0 card-title">User Management</h4>
                            <nav aria-label="breadcrumb" class="ms-auto">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item d-flex align-items-center">
                                        <a class="text-muted text-decoration-none d-flex" href="{{ route('admin.dashboard') }}">
                                            <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                            Users
                                        </span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card bg-primary text-white shadow-lg border-0 rounded-4">
                        <div class="card-body p-3 text-center">
                            <h6 class="text-white-50 mb-1">Total Users</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card bg-success text-white shadow-lg border-0 rounded-4">
                        <div class="card-body p-3 text-center">
                            <h6 class="text-white-50 mb-1">Admins</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['admins'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card bg-info text-white shadow-lg border-0 rounded-4">
                        <div class="card-body p-3 text-center">
                            <h6 class="text-white-50 mb-1">Customers</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['customers'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card bg-warning text-white shadow-lg border-0 rounded-4">
                        <div class="card-body p-3 text-center">
                            <h6 class="text-white-50 mb-1">New Today</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['new_today'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-3">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fa-solid fa-search"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light" 
                                       placeholder="Search by name or email..."
                                       wire:model.live="search">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" wire:model.live="roleFilter">
                                <option value="">All Roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" wire:model.live="perPage">
                                <option value="10">10 Per Page</option>
                                <option value="25">25 Per Page</option>
                                <option value="50">50 Per Page</option>
                                <option value="100">100 Per Page</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary w-100" wire:click="createUser">
                                    <i class="fa-solid fa-plus me-1"></i> Add User
                                </button>
                                <button class="btn btn-outline-secondary" wire:click="resetFilters" title="Reset Filters">
                                    <i class="fa-solid fa-rotate-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4" wire:click="sortBy('id')" style="cursor: pointer; min-width: 60px;">
                                        # 
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </th>
                                    <th wire:click="sortBy('name')" style="cursor: pointer; min-width: 180px;">
                                        Name
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </th>
                                    <th wire:click="sortBy('email')" style="cursor: pointer; min-width: 200px;">
                                        Email
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </th>
                                    <th style="min-width: 140px;">Roles</th>
                                    <th wire:click="sortBy('created_at')" style="cursor: pointer; min-width: 150px;">
                                        Joined
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </th>
                                    <th class="pe-4 text-center" style="min-width: 140px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td class="ps-4">{{ $user->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-circle">
                                                    @if($user->avatar)
                                                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                                                    @else
                                                        <span class="avatar-initials">{{ $user->initials() }}</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $user->name }}</div>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @forelse($user->roles as $role)
                                                <span class="badge bg-{{ $this->getRoleBadge($role->name) }} me-1">
                                                    {{ ucfirst($role->name) }}
                                                </span>
                                            @empty
                                                <span class="badge bg-blue">Customer</span>
                                            @endforelse
                                        </td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="pe-4">
                                            <div class="d-flex justify-content-center gap-1">
                                                {{-- <button class="btn btn-sm btn-outline-primary" wire:click="viewUser({{ $user->id }})" title="View">
                                                    <iconify-icon icon="mdi:eye-outline" class=""></iconify-icon>
                                                </button> --}}
                                                <button class="btn btn-sm btn-outline-warning" wire:click="editUser({{ $user->id }})" title="Edit">
                                                    <iconify-icon icon="solar:pen-new-square-linear" class=""></iconify-icon>
                                                </button>
                                                @if($user->id !== auth()->id())
                                                    <button class="btn btn-sm btn-outline-danger" wire:click="confirmDelete({{ $user->id }})" title="Delete">
                                                        <iconify-icon icon="mdi:delete-outline" class=""></iconify-icon>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-users fa-3x mb-3 d-block"></i>
                                            <h6>No users found</h6>
                                            <small>Try adjusting your search or filter criteria</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
                        </span>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" wire:ignore.self data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form wire:submit.prevent="saveUser">
                    <div class="modal-header border-0 pt-4 px-4">
                        <h5 class="modal-title fw-bold">
                            {{ $modalMode === 'create' ? 'Add New User' : 'Edit User' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="resetForm"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       wire:model="name" placeholder="Enter full name">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       wire:model="email" placeholder="Enter email address">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Password 
                                    @if($modalMode === 'edit') 
                                        <span class="text-muted fw-normal">(Leave blank to keep current)</span>
                                    @else
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       wire:model="password" placeholder="{{ $modalMode === 'edit' ? 'Enter new password (optional)' : 'Enter password' }}">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Confirm Password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       wire:model="password_confirmation" placeholder="Confirm password">
                                @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Roles</label>
                                <select class="form-select" wire:model="selectedRoles" multiple style="height: 100px;">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Hold Ctrl/Cmd to select multiple roles</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 px-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetForm">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>
                                {{ $modalMode === 'create' ? 'Create User' : 'Update User' }}
                            </span>
                            <span wire:loading>
                                <i class="fa-solid fa-spinner fa-spin me-1"></i> Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <div class="bg-danger-subtle rounded-circle d-inline-flex p-3">
                            <i class="fa-solid fa-triangle-exclamation text-danger fa-3x"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-2">Delete User</h5>
                    <p class="text-muted mb-4">
                        Are you sure you want to delete this user? This action cannot be undone.
                    </p>
                    <div class="d-flex gap-3 justify-content-center">
                        <button class="btn btn-secondary px-4" data-bs-dismiss="modal" wire:click="$set('deleteId', null)">
                            Cancel
                        </button>
                        <button class="btn btn-danger px-4" wire:click="deleteUser" wire:loading.attr="disabled">
                            <span wire:loading.remove>Delete</span>
                            <span wire:loading>
                                <i class="fa-solid fa-spinner fa-spin me-1"></i> Deleting...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            flex-shrink: 0;
        }

        .avatar-initials {
            font-size: 14px;
            font-weight: 600;
        }

        .table th {
            font-weight: 600;
            color: #475569;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
        }

        select[multiple] {
            height: 100px !important;
        }
    </style>
    <script>
    window.addEventListener('show-user-modal', () => {
        console.log('show-user-modal event received');
        const modalEl = document.getElementById('userModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    });

    window.addEventListener('show-delete-modal', () => {
        const modalEl = document.getElementById('deleteModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    });

    window.addEventListener('hide-modals', () => {
        const userModalEl = document.getElementById('userModal');
        const userModal = bootstrap.Modal.getInstance(userModalEl);
        if (userModal) userModal.hide();

        const deleteModalEl = document.getElementById('deleteModal');
        const deleteModal = bootstrap.Modal.getInstance(deleteModalEl);
        if (deleteModal) deleteModal.hide();
    });
</script>
</div>

@push('scripts')

@endpush