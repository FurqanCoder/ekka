<?php

namespace App\Livewire\Web\Components\Wish;

use Livewire\Component;

class WishIcon extends Component
{
    public $count = 0;

    protected $listeners = ['countWish' => 'updateCount'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $this->count = count(app('wishlist')->getWishlist());
    }

    public function render()
    {
        return view('livewire.web.components.wish.wish-icon');
    }
}
