<?php

namespace App\Livewire\Catalog;

use Livewire\Component;

class About extends Component
{
    public function render()
    {
        return view('livewire.catalog.about')->layout('layouts.customer');
    }
}
