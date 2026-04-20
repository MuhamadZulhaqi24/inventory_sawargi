<?php

namespace App\Livewire\Companies;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class CompanyIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['refresh-companies' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        $company = Company::findOrFail($id);
        $company->status = $company->status === 'active' ? 'inactive' : 'active';
        $company->save();

        session()->flash('messages', 'Company status updated successfully.');
    }

    public function render()
    {
        $companies = Company::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('slug', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.companies.company-index', [
            'companies' => $companies
        ]);
    }
}
