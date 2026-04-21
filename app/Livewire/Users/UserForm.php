<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\DTOs\UserData;
use App\Services\UserService;
use Illuminate\Validation\Rule;

class UserForm extends Component
{
    public ?User $user = null;
    public bool $isEditing = false;

    public $name;
    public $username;
    public $email;
    public $role = 'staff';
    public $company_id;
    public $password;
    public $password_confirmation;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($this->user?->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user?->id)],
            'role' => ['required', 'in:owner,manager,staff'],
            'company_id' => [auth()->user()->is_super_admin ? 'required' : 'nullable', 'exists:companies,id'],
            'password' => [$this->isEditing ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ];
    }

    #[On('open-modal')]
    public function handleOpenModal($name): void
    {
        if ($name === 'user-form-modal' && !$this->isEditing) {
            $this->reset(['user', 'isEditing', 'name', 'username', 'email', 'role', 'company_id', 'password', 'password_confirmation']);
            $this->company_id = auth()->user()->company_id;
        }
    }

    public function create(): void
    {
        $this->reset(['user', 'isEditing', 'name', 'username', 'email', 'role', 'company_id', 'password', 'password_confirmation']);
        $this->company_id = auth()->user()->company_id;
        $this->dispatch('open-modal', name: 'user-form-modal');
    }

    #[On('edit-user')]
    public function edit(User $user): void
    {
        $this->user = $user;
        $this->isEditing = true;

        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->company_id = $user->company_id;
        $this->password = '';
        $this->password_confirmation = '';

        $this->dispatch('open-modal', name: 'user-form-modal');
    }

    public function save(UserService $service): void
    {
        $this->validate();

        // 1. Tentukan Company ID (Otomatis jika bukan Super Admin)
        $targetCompanyId = auth()->user()->is_super_admin ? $this->company_id : auth()->user()->company_id;
        
        // 2. Keamanan Role: Cegah tenant admin membuat 'Owner' baru
        if (!auth()->user()->is_super_admin && strtolower($this->role) === 'owner') {
             throw new \Exception('Maaf, Anda tidak memiliki izin untuk membuat atau mengedit user dengan role Owner.');
        }

        // 3. Cari Role ID yang sesuai
        $roleModel = \App\Models\Role::where('company_id', $targetCompanyId)
            ->where('name', 'like', $this->role)
            ->first();

        $data = new UserData(
            name: $this->name,
            username: $this->username,
            email: $this->email,
            role: $this->role,
            password: $this->password ?: null,
        );

        try {
            if ($this->isEditing && $this->user) {
                // Update User
                $this->user->role_id = $roleModel?->id;
                $this->user->company_id = $targetCompanyId; // Pastikan terkunci ke company yang benar
                $service->updateUser($this->user, $data);
                $message = __('messages.user_updated');
            } else {
                // Create User
                $newUser = $service->createUser($data);
                $newUser->role_id = $roleModel?->id;
                $newUser->company_id = $targetCompanyId;
                $newUser->save();
                $message = __('messages.user_created');
            }

            $this->dispatch('close-modal', name: 'user-form-modal');
            $this->dispatch('pg:eventRefresh-user-table');
            $this->dispatch('toast', message: $message, type: 'success');

            // Reset after save
            $this->reset(['user', 'isEditing', 'name', 'username', 'email', 'password', 'password_confirmation']);

        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.users.user-form');
    }
}
