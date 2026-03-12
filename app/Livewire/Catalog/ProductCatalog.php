<?php

namespace App\Livewire\Catalog;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCatalog extends Component
{
    use WithPagination;

    public $search = '';
    public $category_id = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'category_id' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::query()
            ->with(['category', 'unit'])
            ->where('is_active', true)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->category_id, function ($query) {
                $query->where('category_id', $this->category_id);
            })
            ->orderBy('name')
            ->paginate(12);

        $categories = Category::orderBy('name')->get();

        return view('livewire.catalog.product-catalog', [
            'products' => $products,
            'categories' => $categories,
        ])->layout('layouts.customer');
    }
}
