<?php

namespace App\Livewire\Content;

// Flux not imported to avoid undefined type issues; if Flux exists it will be referenced with a fully-qualified name.

use App\Events\AiResultDone;
use App\Jobs\AiFoodJob;
use App\Models\Content;
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
        // User Is Auth

        // User Can Create Content

        // User Subscription Active

        // User Info Health Is Full

        $content = null;
        if($this->selectedTab == 'photo') {
            $data = $this->validate([
                'photo' => ['image','required'],
                'model' => ['string','required','in:ProductAnalyzer,MealCreator,PreparedDishAnalyzer']
            ]);
            // Handle Image User
            $content = Content::create([
                'user_id' => auth()->id(),
                'type' => $data['model'],
                'image_path' => $data['photo']->store('photos','public')  ?? null,
            ]);
        } else {
            $data = $this->validate([
                'text' => ['string','required','max:200'],
                'model' => ['string','required','in:ProductAnalyzer,MealCreator,PreparedDishAnalyzer']
            ]);
            $content = Content::create([
                'user_id' => auth()->id(),
                'type' => $data['model'],
                'title' => $data['text'],
            ]);
        }
        // Dispatch Job AI Food
        AiFoodJob::dispatch($content);

        // broadcast(new AiResultDone($content));




        return redirect()->route('content.show',$content->slug);
    }

    public function render()
    {
        return view('livewire.content.content-form');
    }
}
