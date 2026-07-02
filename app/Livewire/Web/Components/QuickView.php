<?php

namespace App\Livewire\Web\Components;

use Livewire\Component;

class QuickView extends Component
{
    public $productId;
    public $addmodal;
    public function mount($id)
    {
        $this->productId = $id;
        // dd($id);
    }
    public function openModal(){
        $this->addmodal = 1;
        // dd($this->productId);
        $this->dispatch('showQuickModal', ['product_id' => $this->productId]);
    }
    public function render()
    {
        return view('livewire.web.components.quick-view');
    }
}
