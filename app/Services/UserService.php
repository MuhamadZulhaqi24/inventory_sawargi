<?php

namespace App\Services;

use App\Models\User;
use App\DTOs\UserData;
use App\Models\Purchase;
use App\Models\FinanceTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Traits\LogsActivity;

class UserService
{
    use LogsActivity;

    /**
     * Create a new user.
     */
    public function createUser(UserData $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data->name,
                'username' => $data->username,
                'email' => $data->email,
                'role' => $data->role,
                'password' => $data->password,
            ]);

            $this->recordActivity('create', 'users', "Menambahkan pengguna baru: {$user->name}");

            return $user;
        });
    }

    /**
     * Update an existing user.
     */
    public function updateUser(User $user, UserData $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $updateData = [
                'name' => $data->name,
                'username' => $data->username,
                'email' => $data->email,
                'role' => $data->role,
            ];

            if ($data->password) {
                $updateData['password'] = $data->password;
            }

            $user->update($updateData);

            $this->recordActivity('update', 'users', "Memperbarui informasi pengguna: {$user->name}");

            return $user;
        });
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user): void
    {
        if ($user->id === Auth::id()) {
            throw ValidationException::withMessages(['user' => 'You cannot delete your own account.']);
        }

        if ($user->sales()->exists()) {
            throw ValidationException::withMessages(['user' => 'Cannot delete user who has recorded sales.']);
        }

        if (Purchase::where('created_by', $user->id)->exists()) {
            throw ValidationException::withMessages(['user' => 'Cannot delete user who has recorded purchases.']);
        }

        if (FinanceTransaction::where('created_by', $user->id)->exists()) {
            throw ValidationException::withMessages(['user' => 'Cannot delete user who has recorded finance transactions.']);
        }

        $userName = $user->name;
        $user->delete();
        
        $this->recordActivity('delete', 'users', "Menghapus pengguna: {$userName}");
    }
}
