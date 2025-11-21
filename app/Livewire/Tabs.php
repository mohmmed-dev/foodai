<?php

namespace App\Livewire;

use Livewire\Component;

class Tabs extends Component
{
    public $type = 'scan';

    public function change($type) {
        $this->type = $type;
    }
    public function render()
    {
        return view('livewire.tabs');
    }
}
