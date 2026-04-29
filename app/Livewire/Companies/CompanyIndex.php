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

    public function extendSubscription($id, $days = 30)
    {
        $company = Company::findOrFail($id);
        
        // Jika sudah expired, mulai dari hari ini. Jika belum, tambahkan dari tanggal expired lama.
        $startDate = ($company->expired_at && $company->expired_at->isFuture()) 
            ? $company->expired_at 
            : now();

        $company->expired_at = $startDate->addDays($days);
        $company->status = 'active'; // Otomatis aktifkan kembali jika sebelumnya nonaktif
        $company->save();

        $this->dispatch('toast', message: "Masa aktif {$company->name} berhasil diperpanjang {$days} hari.", type: 'success');
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
