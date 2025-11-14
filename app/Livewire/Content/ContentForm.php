<?php

namespace App\Livewire\Content;

// Flux not imported to avoid undefined type issues; if Flux exists it will be referenced with a fully-qualified name.
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContentForm extends Component
{
    use WithFileUploads;
    public $selectedTab = 'photo';
    // public $model_6 = false;
    #[Validate('image|nullable')]
    public $photo;
    #[Validate('string|max:200|nullable')]
    public $text;
    #[Validate('required|string')]
    public $model;
    public function save() {
        if($this->selectedTab == 'photo') {
            $data = $this->validate([
                'photo' => ['image','required'],
                'model' => ['string','required','in:ProductAnalyzer,MealCreator,PreparedDishAnalyzer']
            ]);
        } else {
            $data = $this->validate([
                'text' => ['string','required','max:200'],
                'model' => ['string','required','in:ProductAnalyzer,MealCreator,PreparedDishAnalyzer']
            ]);
        }
        
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.content.content-form');
    }
}
