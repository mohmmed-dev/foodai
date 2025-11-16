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
    #[On('echo:ai_result.{content.id},ContentShow')]
    public function refreshUser(Content $content)
    {
        $this->content = $content; 
    }
    //    #[On('echo:ai_result.{content.id},AiResultDone')]
    // public function refreshUser($payload)
    // {
    //     // Payload shape: ['content' => [...content fields...]] per broadcastWith()
    //     if (is_array($payload) && isset($payload['content']['id'])) {
    //         $this->content = Content::find($payload['content']['id']) ?? $this->content;
    //         return;
    //     }

    //     // If the payload is an id or contains id at top-level
    //     if (is_array($payload) && isset($payload['id'])) {
    //         $this->content = Content::find($payload['id']) ?? $this->content;
    //         return;
    //     }

    //     // Fallback: replace with payload directly if it's already a model
    //     $this->content = $payload instanceof Content ? $payload : $this->content;
    // }
    public function render()
    {
        return view('livewire.content.content-show');
    }
}
