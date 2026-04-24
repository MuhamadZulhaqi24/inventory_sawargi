<?php

namespace App\Livewire\Settings;

use App\Models\Company;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class CompanySettings extends Component
{
    use WithFileUploads, WithPagination;

    public $activeTab = 'profile';

    // Business Profile Fields
    public $name, $address, $phone, $logo;
    
    // Roles Management Fields
    public $roles;
    public $role_id, $role_name;
    public $selected_permissions = [];
    public $isRoleModalOpen = false;

    // Available Permissions List
    public $availablePermissions = [
        'access_pos' => 'Kasir (POS)',
        'view_reports' => 'Laporan Penjualan',
        'manage_inventory' => 'Kelola Stok & Produk',
        'manage_finance' => 'Keuangan & Biaya',
        'manage_users' => 'Kelola Karyawan',
        'manage_settings' => 'Pengaturan Perusahaan',
    ];

    // Platform Stats (For Super Admin)
    public $total_companies, $total_users, $total_revenue;
    public $maintenance_mode, $maintenance_message;

    public function mount()
    {
        if (auth()->user()->is_super_admin) {
            $this->activeTab = 'platform';
            $this->total_companies = \App\Models\Company::count();
            $this->total_users = \App\Models\User::count();
            $this->total_revenue = \App\Models\Sale::withoutGlobalScopes()->sum('total');
            $this->maintenance_mode = \App\Models\Setting::getGlobal('maintenance_mode') === '1';
            $this->maintenance_message = \App\Models\Setting::getGlobal('maintenance_message', 'Sistem sedang dalam pemeliharaan rutin.');
            return;
        }

        $company = auth()->user()->company;
        if ($company) {
            $this->name = $company->name;
            $settings = $company->settings ?? [];
            $this->address = $settings['address'] ?? '';
            $this->phone = $settings['phone'] ?? '';
        }
        
        $this->refreshRoles();
    }

    public function clearCache()
    {
        if (!auth()->user()->is_super_admin) return;
        
        try {
            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            $this->dispatch('toast', message: 'System cache cleared successfully.', type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }

    public function saveMaintenance()
    {
        if (!auth()->user()->is_super_admin) return;

        \App\Models\Setting::setGlobal('maintenance_mode', $this->maintenance_mode ? '1' : '0');
        \App\Models\Setting::setGlobal('maintenance_message', $this->maintenance_message);

        $this->dispatch('toast', message: 'Maintenance mode updated.', type: 'success');
    }

    public function refreshRoles()
    {
        if (auth()->user()->company_id) {
            $this->roles = Role::where('company_id', auth()->user()->company_id)->get();
        }
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|min:3',
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        $company = auth()->user()->company;
        $company->update([
            'name' => $this->name,
            'settings' => array_merge($company->settings ?? [], [
                'address' => $this->address,
                'phone' => $this->phone,
            ])
        ]);

        $this->dispatch('toast', message: 'Profil bisnis berhasil diperbarui.', type: 'success');
    }

    public function openRoleModal($id = null)
    {
        $this->resetErrorBag();
        if ($id) {
            $role = Role::where('company_id', auth()->user()->company_id)->findOrFail($id);
            $this->role_id = $role->id;
            $this->role_name = $role->name;
            
            $perms = $role->permissions ?? [];
            if (!empty($perms) && !isset($perms[0])) {
                $this->selected_permissions = array_keys(array_filter($perms));
            } else {
                $this->selected_permissions = (array) $perms;
            }
        } else {
            $this->role_id = null;
            $this->role_name = '';
            $this->selected_permissions = [];
        }
        $this->isRoleModalOpen = true;
    }

    public function saveRole()
    {
        $this->validate([
            'role_name' => 'required|min:2',
        ]);

        $cleanPermissions = array_values(array_intersect(
            (array) $this->selected_permissions, 
            array_keys($this->availablePermissions)
        ));

        Role::updateOrCreate(
            ['id' => $this->role_id, 'company_id' => auth()->user()->company_id],
            [
                'company_id' => auth()->user()->company_id,
                'name' => $this->role_name,
                'permissions' => $cleanPermissions,
                'is_immutable' => $this->role_id && Role::find($this->role_id)->is_immutable ? true : false,
            ]
        );

        $this->isRoleModalOpen = false;
        $this->refreshRoles();
        $this->dispatch('toast', message: 'Role berhasil disimpan.', type: 'success');
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        if ($role->is_immutable) {
            return $this->dispatch('toast', message: 'Role utama tidak bisa dihapus.', type: 'error');
        }
        
        if ($role->users()->count() > 0) {
            return $this->dispatch('toast', message: 'Role masih digunakan oleh karyawan.', type: 'error');
        }

        $role->delete();
        $this->refreshRoles();
        $this->dispatch('toast', message: 'Role berhasil dihapus.', type: 'success');
    }

    public function render()
    {
        $logs = collect();
        if ($this->activeTab === 'logs') {
            $logs = \App\Models\ActivityLog::with('user')
                ->latest()
                ->paginate(10);
        }

        return view('livewire.settings.company-settings', [
            'logs' => $logs
        ]);
    }
}
