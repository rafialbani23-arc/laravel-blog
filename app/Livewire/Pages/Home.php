<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Home extends Component
{
    public function render()
    {
        return view('livewire.pages.home');
    }
}
