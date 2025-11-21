<?php

namespace App\Jobs;

use App\Events\AiResultDone;
use App\Models\Content;
use App\Servers\Ai\HalalAnalyzer;
use App\Servers\Ai\HalalCreator;
use App\Traits\StringToJson;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Prism\Prism\ValueObjects\Media\Image;


class AiFoodJob implements ShouldQueue
{
    use Queueable,StringToJson;

    /**
     * Create a new job instance.
     */
    public $content;
    public $user;
    public $user_info;

    public function __construct(Content $content)
    {
        $this->content = $content;
        $this->user = $content->user;
        $this->user->load('personality');
        $this->user_info = $this->getUserInfo($this->user->personality);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // // Load Content And User
        $content = $this->content;
        $user = $this->user;
        $user_info = $this->user_info;
        $result = null;

        if($this->content->type == 'ProductAnalyzer') {
            $result = HalalAnalyzer::HalalAnalyzerAi($content->title,$content->image_path,$user_info);
        } elseif($this->content->type == 'MealCreator') {
            $result = HalalCreator::HalalCreatorAI($content->title,$content->image_path,$user_info);
        } else {

        }
        // Save Result
        $result = StringToJson::parseAiJson($result);
        if($result) {
            $content->body = $result;
            $content->progress = 'completed';
            $content->save();
        } else {
            $content->progress = 'error';
            $content->error = 1;
            $content->save();
            return;
        }
        // LARAVEL EVENT for notify user
        // Tryend Job
        broadcast(new AiResultDone($content));

            return;
        // End Job
    }

    public function getUserInfo($personality) {
        $allergies = json_encode($personality->allergies);
        $chronic_diabetes = json_encode($personality->chronic_diabetes);
        $health_goals = json_encode($personality->health_goals);
        $custom_preferences = json_encode($personality->custom_preferences);
        $text = "
            gender:$personality->gender
            age:$personality->age
            weight:$personality->weight
            height:$personality->height
            activity_level:$personality->activity_level
            bmr:$personality->bmr
            tdee:$personality->tdee
            goal:$personality->goal
            chronic_diabetes:$chronic_diabetes
            allergies:$allergies
            health_goals:$health_goals
            custom_preferences:$custom_preferences
        ";
        return trim(preg_replace('/\s+/','',$text));
    }
}
