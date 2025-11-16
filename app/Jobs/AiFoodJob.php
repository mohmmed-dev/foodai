<?php

namespace App\Jobs;

use App\Events\AiResultDone;
use App\Models\Content;
use App\Servers\Ai\HalalAnalyzer;
use App\Servers\Ai\HalalCreator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Prism\Prism\ValueObjects\Media\Image;


class AiFoodJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $content;
    public $user;

    public function __construct(Content $content)
    {
        $this->content = $content;
        $this->user = $content->user;
        $this->user->load('personality');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        // // Load Content And User
        // $content = $this->content;
        // $user = $this->user;
        // $personality = $user->personality == null ? null : $user->personality->toArray();
        // // Prepare Image If Available
        // if($content->image_path) {
        //     $imagePath = [Image::fromLocalPath(storage_path('app/public/'.$content->image_path))];
        // } else {
        //     $imagePath = null;
        // }
        // // Select Model AI
        // $result = null;
        // if($this->content->type == 'ProductAnalyzer') {
        //     $result = HalalAnalyzer::HalalAnalyzerAi($content->title,$imagePath);
        // } elseif($this->content->type == 'MealCreator') {
        //     $result = HalalCreator::HalalCreatorAI($content->title,$imagePath);
        // } else {  

        // }
        // // Save Result
        // if($result) {
        //     $content->body = $result;
        //     $content->progress = 'completed';
        //     $content->save();
        // } else {
        //     $content->progress = 'error';
        //     $content->error = 1;
        //     $content->save();
        //     return;
        // }
        
        // $content->title = $result['title'];
        // $content->save();
        // dd($this->content.$this->user);
        
        // LARAVEL EVENT for notify user
        // Tryend Job
            $content = $this->content;
            $content->progress = 'error';

            $content->self = 1;
            $content->error = 1;
            $content->save();
            broadcast(new AiResultDone($content));
            return;
        // End Job
    }
}
