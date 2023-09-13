<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class PackageCard extends Component
{
    public $item;

    public function mount($item)
    {
        $this->item = $item;
    }

    public function render()
    {
        return view('livewire.frontend.package-card');
    }
}
