<?php

namespace App\Livewire\Web\Components\Home;

use App\Models\Category as ModalCategory;
use Livewire\Component;

class Category extends Component
{
    public $categories;

    public function mount()
    {
        $this->categories = ModalCategory::whereNull('parent_id')->Where('status', 'active')
            ->take(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.web.components.home.category');
    }
}

