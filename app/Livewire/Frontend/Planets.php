<?php

namespace App\Livewire\Frontend;

use App\Models\PackagistPackage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.verse')]
class Planets extends Component
{
    use WithPagination;

    public $search;

    public function jump($planet)
    {
        return $this->redirect("/$planet", navigate: true);
    }

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

        return view('livewire.frontend.planets', compact('items'));
    }
}
