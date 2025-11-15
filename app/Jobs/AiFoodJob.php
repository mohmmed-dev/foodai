<?php

namespace App\Jobs;

use App\Models\Content;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AiFoodJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $content;
    public function __construct(Content $content)
    {
        $this->content = $content;

        // Get User Info


    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Is Image or Text

        // Select Model AI

        // Chase Rhtie AI
    }
}
