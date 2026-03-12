<?php

namespace App\Livewire\Catalog;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $featuredCategories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(4)
            ->get();

        $recentProducts = Product::where('is_active', true)
            ->with(['unit'])
            ->latest()
            ->take(8)
            ->get();

        return view('livewire.catalog.home', [
            'featuredCategories' => $featuredCategories,
            'recentProducts' => $recentProducts,
        ])->layout('layouts.customer');
    }
}
