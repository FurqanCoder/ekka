<?php

namespace App\Livewire\Web\Components\Wish;
use App\Services\WishlistService;
use Livewire\Component;

class Button extends Component
{
    public $productId;
    public $inWishlist = false;
    public function mount($id){
        $this->productId = $id;
        $this->inWishlist = in_array($id, app('wishlist')->getWishlist());
    }
    public function addWish(){
        $this->inWishlist = app('wishlist')->toggle($this->productId);
        $this->dispatch('countWish');
    }
    public function render()
    {
        return view('livewire.web.components.wish.button');
    }
}
