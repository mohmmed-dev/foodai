<?php

namespace App\Livewire\Content;

use App\Models\Content;
use Livewire\Attributes\On;
use Livewire\Component;

class ContentShow extends Component
{
    public $content;
    public function mount($content)
    {
        $this->content = $content;
    }
// 'ai_Result', $this->content->user_id
    #[On('echo-private:ai.result.{content.id},.ai.result.done')]
    public function refreshUser(Content $content)
    {
        $this->content = $content;
    }
    public function render()
    {
        return view('livewire.content.content-show');
    }
}
