<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            // 1. Create Default Roles for this company
            $ownerRole = Role::updateOrCreate(
                ['company_id' => $company->id, 'name' => 'Owner'],
                [
                    'is_immutable' => true,
                    'permissions' => [
                        'access_pos' => true,
                        'view_reports' => true,
                        'manage_inventory' => true,
                        'manage_finance' => true,
                        'manage_users' => true,
                        'manage_settings' => true,
                    ]
                ]
            );

            $managerRole = Role::updateOrCreate(
                ['company_id' => $company->id, 'name' => 'Manager'],
                [
                    'is_immutable' => false,
                    'permissions' => [
                        'access_pos' => true,
                        'view_reports' => true,
                        'manage_inventory' => true,
                        'manage_finance' => false,
                        'manage_users' => true,
                        'manage_settings' => false,
                    ]
                ]
            );

            $staffRole = Role::updateOrCreate(
                ['company_id' => $company->id, 'name' => 'Staff'],
                [
                    'is_immutable' => false,
                    'permissions' => [
                        'access_pos' => true,
                        'view_reports' => false,
                        'manage_inventory' => true,
                        'manage_finance' => false,
                        'manage_users' => false,
                        'manage_settings' => false,
                    ]
                ]
            );

            // 2. Map existing users to these roles
            $users = User::where('company_id', $company->id)->get();
            foreach ($users as $user) {
                if ($user->role === 'owner') {
                    $user->role_id = $ownerRole->id;
                } elseif ($user->role === 'manager') {
                    $user->role_id = $managerRole->id;
                } else {
                    $user->role_id = $staffRole->id;
                }
                $user->save();
            }
        }
    }
}
