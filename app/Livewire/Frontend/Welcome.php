<?php

namespace App\Livewire\Frontend;

use App\Models\PackagistPackage;
use Livewire\Component;
use Livewire\WithPagination;

class Welcome extends Component
{
    use WithPagination;

    public $items = [];

    public $search;

    public function render()
    {
        if ($this->search) {
            $this->items = PackagistPackage::where('title', 'like', '%'.$this->search.'%')
                ->orWhere('slug', 'like', '%'.$this->search.'%')
                ->limit(150)->get();
        } else {
            $this->items = PackagistPackage::skip(0)->take(15)->get();
        }

        return view('livewire.frontend.welcome');
    }
}
