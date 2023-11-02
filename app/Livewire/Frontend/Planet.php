<?php

namespace App\Livewire\Frontend;

use App\Models\PackagistPackage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.verse')]
class Planet extends Component
{
    use WithPagination;

    public $search;

    public function mount()
    {
        $this->search = request()->query('search', '');
    }

    public function render()
    {
        if ($this->search) {
            $items = PackagistPackage::search($this->search)->paginate(15);
        } else {
            $items = PackagistPackage::paginate(15);
        }

        return view('livewire.frontend.planet', compact('items'));
    }
}
