<?php

namespace App\Livewire\Catalog;

use Livewire\Component;

class Contact extends Component
{
    public $name;
    public $email;
    public $subject;
    public $message;

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ];
    }

    public function sendMessage()
    {
        $this->validate();

        // Normally you'd send an email or save to DB here
        $this->dispatch('toast', message: __('Pesan Anda telah terkirim!'), type: 'success');
        $this->reset(['name', 'email', 'subject', 'message']);
    }

    public function render()
    {
        return view('livewire.catalog.contact')->layout('layouts.customer');
    }
}
