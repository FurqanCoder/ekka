<?php

namespace App\Livewire\Web\Components\Global;

use Livewire\Component;

class MobileFooter extends Component
{

    public function render()
    {
        return view('livewire.web.components.global.mobile-footer');
    }
    public function showLogin(){
        $this->dispatch('showLogin');
    }
}
