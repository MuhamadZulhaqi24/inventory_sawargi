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
    public $role; // Hilangkan default 'staff'
    public $role_id; // Tambahkan deklarasi ini
    public $company_id;
    public $password;
    public $password_confirmation;

    /**
     * Get the available roles for the current selection.
     */
    public function getAvailableRolesProperty()
    {
        $targetCompanyId = auth()->user()->is_super_admin ? $this->company_id : auth()->user()->company_id;
        
        if (!$targetCompanyId) {
            return collect();
        }

        $roles = \App\Models\Role::where('company_id', $targetCompanyId)->get();

        // Security: Filter out 'Owner' role for non-super admin
        if (!auth()->user()->is_super_admin) {
            $roles = $roles->filter(fn($r) => strtolower($r->name) !== 'owner');
        }

        return $roles;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($this->user?->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user?->id)],
            'role_id' => ['required', 'exists:roles,id'],
            'company_id' => [auth()->user()->is_super_admin ? 'required' : 'nullable', 'exists:companies,id'],
            'password' => [$this->isEditing ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ];
    }

    #[On('open-modal')]
    public function handleOpenModal($name): void
    {
        if ($name === 'user-form-modal' && !$this->isEditing) {
            $this->clearForm();
        }
    }

    #[On('create-user')]
    public function create(): void
    {
        $this->isEditing = false;
        $this->user = null;
        $this->clearForm();
        $this->dispatch('open-modal', name: 'user-form-modal');
    }

    private function clearForm()
    {
        $this->reset(['name', 'username', 'email', 'role_id', 'password', 'password_confirmation']);
        $this->role = null;
        $this->company_id = auth()->user()->company_id;
        
        // JANGAN set default role_id agar muncul "Pilih Role"
        $this->role_id = null;
    }

    #[On('edit-user')]
    public function edit(User $user): void
    {
        $this->resetErrorBag();
        $this->user = $user;
        $this->isEditing = true;

        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->company_id = $user->company_id;
        $this->password = '';
        $this->password_confirmation = '';

        $this->dispatch('open-modal', name: 'user-form-modal');
    }

    public function save(UserService $service): void
    {
        $this->validate();

        // 1. Tentukan Company ID
        $targetCompanyId = auth()->user()->is_super_admin ? $this->company_id : auth()->user()->company_id;
        
        // 2. Keamanan Role: Ambil objek role untuk cek nama
        $selectedRole = \App\Models\Role::find($this->role_id);
        if (!auth()->user()->is_super_admin && strtolower($selectedRole?->name) === 'owner') {
             throw new \Exception('Maaf, Anda tidak memiliki izin untuk memberikan role Owner.');
        }

        $data = new UserData(
            name: $this->name,
            username: $this->username,
            email: $this->email,
            role: $selectedRole?->name ?? 'staff', // Sync legacy field
            password: $this->password ?: null,
        );

        try {
            if ($this->isEditing && $this->user) {
                // Update User
                $this->user->role_id = $this->role_id;
                $this->user->company_id = $targetCompanyId;
                $service->updateUser($this->user, $data);
                $message = __('messages.user_updated');
            } else {
                // Create User
                $newUser = $service->createUser($data);
                $newUser->role_id = $this->role_id;
                $newUser->company_id = $targetCompanyId;
                $newUser->save();
                $message = __('messages.user_created');
            }

            $this->dispatch('close-modal', name: 'user-form-modal');
            $this->dispatch('pg:eventRefresh-user-table');
            $this->dispatch('toast', message: $message, type: 'success');

            // Reset after save
            $this->user = null;
            $this->isEditing = false;
            $this->clearForm();

        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.users.user-form');
    }
}
