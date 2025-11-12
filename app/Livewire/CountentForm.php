<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CountentForm extends Component
{
    use WithFileUploads;
    #[Validate('image')]
    public $photo;
    #[Validate('required|string')]
    public $model;
    #[Validate('required')]
    public $user;


    public function save() {
        dd('dd');
        $date = $this->validate();
        dd($date);
        // $this->photo->store('potots');
    }

    public function render()
    {
        return view('livewire.countent-form');
    }
}
