<?php

namespace App\Events;

use App\Models\Content;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AiResultDone implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $content;
    public function __construct(Content $content)
    {
        //
        $this->content = $content;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Broadcast on the private channel named "ai_result.{id}" so it matches
        // the channel definition in routes/channels.php (ai_result.{contentId}).
        return [
            new PrivateChannel("ai_result.{$this->content->id}"),
        ];
    }

    /**
     * Optional: provide a stable event name that Echo/Livewire can listen for
     * and a predictable payload.
     */
    public function broadcastWith(): array
    {
        return [
            'content' => $this->content->toArray(),
        ];
    }

    public function broadcastAs(): string
    {
        return 'AiResultDone';
    }
}
