<?php

namespace App\Livewire\Companies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class CompanyForm extends Component
{
    public $name, $business_type = 'retail', $admin_name, $admin_email, $admin_password;
    public $isOpen = false;

    protected $listeners = ['open-modal' => 'checkModal'];

    protected $rules = [
        'name' => 'required|string|min:3',
        'business_type' => 'required|in:retail,health,library',
        'admin_name' => 'required|string|min:3',
        'admin_email' => 'required|email|unique:users,email',
        'admin_password' => 'required|min:8',
    ];

    public function checkModal($name)
    {
        if ($name === 'company-form') {
            $this->reset();
            $this->isOpen = true;
        }
    }

    public function save()
    {
        $this->validate();

        // 1. Buat Company
        $company = Company::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name) . '-' . Str::random(5),
            'business_type' => $this->business_type,
            'status' => 'active',
            'expired_at' => now()->addYear(),
        ]);

        // 2. Buat Admin User untuk Company tersebut
        User::create([
            'company_id' => $company->id,
            'name' => $this->admin_name,
            'username' => Str::slug($this->admin_name) . rand(10, 99),
            'email' => $this->admin_email,
            'password' => Hash::make($this->admin_password),
            'is_super_admin' => false,
        ]);

        $this->isOpen = false;
        $this->dispatch('refresh-companies');
        session()->flash('message', 'Tenant and Admin created successfully.');
    }

    public function render()
    {
        return view('livewire.companies.company-form');
    }
}
