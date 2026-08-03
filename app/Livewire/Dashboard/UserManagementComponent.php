<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserManagementComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // User form properties
    public $userId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $roles = [];
    public $selectedRoles = [];
    public $status = 'active';

    // Modal controls
    public $showModal = false;
    public $modalMode = 'create';
    public $showDeleteModal = false;
    public $deleteId = null;

    protected $listeners = ['refreshUsers' => '$refresh'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'selectedRoles' => 'array',
    ];

    protected $messages = [
        'name.required' => 'Name is required.',
        'email.required' => 'Email is required.',
        'email.unique' => 'This email is already registered.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 8 characters.',
        'password.confirmed' => 'Passwords do not match.',
    ];

    public function mount()
    {
        $this->loadRoles();
    }

    public function loadRoles()
    {
        $this->roles = Role::all();
    }

    public function render()
    {
        $users = $this->getUsers();
        
        $stats = [
            'total' => User::count(),
            'admins' => User::role('admin')->count(),
            'customers' => User::role('customer')->count(),
            'new_today' => User::whereDate('created_at', today())->count(),
            'total_orders' => Order::count(),
        ];

        return view('livewire.dashboard.user-management-component', [
            'users' => $users,
            'stats' => $stats,
        ])->extends('layouts.admin')->section('admin-content');
    }

    public function getUsers()
    {
        $query = User::with(['roles', 'orders'])
            ->when($this->search, function ($q) {
                return $q->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function ($q) {
                return $q->whereHas('roles', function ($query) {
                    $query->where('name', $this->roleFilter);
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function createUser()
    {
        // dd('working');  
        $this->resetForm();
        $this->modalMode = 'create';
        $this->showModal = true;
        $this->dispatch('show-user-modal');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
        
        $this->password = '';
        $this->password_confirmation = '';

        $this->modalMode = 'edit';
        $this->showModal = true;
        $this->dispatch('show-user-modal');
    }

    public function saveUser()
    {
        if ($this->modalMode === 'create') {
            $this->validate($this->rules);
        } else {
            $rules = $this->rules;
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $this->userId;
            $rules['password'] = 'nullable|string|min:8|confirmed';
            unset($rules['password_confirmation']);
            $this->validate($rules);
        }

        try {
            if ($this->modalMode === 'create') {
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                ]);

                if (!empty($this->selectedRoles)) {
                    $user->syncRoles($this->selectedRoles);
                } else {
                    $user->assignRole('customer');
                }

                $this->dispatch('notify', [
                    'type' => 'success',
                    'message' => 'User created successfully!'
                ]);
            } else {
                $user = User::findOrFail($this->userId);
                $updateData = [
                    'name' => $this->name,
                    'email' => $this->email,
                ];

                if (!empty($this->password)) {
                    $updateData['password'] = Hash::make($this->password);
                }

                $user->update($updateData);

                if (!empty($this->selectedRoles)) {
                    $user->syncRoles($this->selectedRoles);
                }

                $this->dispatch('notify', [
                    'type' => 'success',
                    'message' => 'User updated successfully!'
                ]);
            }

            $this->showModal = false;
            $this->resetForm();
            $this->resetPage();
            $this->dispatch('hide-modals');

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
        $this->dispatch('show-delete-modal');
    }

    public function deleteUser()
    {
        try {
            $user = User::findOrFail($this->deleteId);
            
            if ($user->id === auth()->id()) {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'You cannot delete your own account.'
                ]);
                $this->showDeleteModal = false;
                $this->dispatch('hide-modals');
                return;
            }

            $user->delete();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'User deleted successfully!'
            ]);

            $this->showDeleteModal = false;
            $this->deleteId = null;
            $this->resetPage();
            $this->dispatch('hide-modals');

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Error deleting user: ' . $e->getMessage()
            ]);
        }
    }

    public function resetForm()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedRoles = [];
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->roleFilter = '';
        $this->perPage = 10;
        $this->resetPage();
    }

    public function getRoleBadge($role)
    {
        $colors = [
            'admin' => 'danger',
            'customer' => 'primary',
            'vendor' => 'success',
            'manager' => 'warning',
        ];
        return $colors[$role] ?? 'secondary';
    }

    public function viewUser($id)
    {
        $this->dispatch('notify', [
            'type' => 'info',
            'message' => 'User details feature coming soon!'
        ]);
    }
}