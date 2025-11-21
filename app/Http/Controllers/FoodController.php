<?php

namespace App\Http\Controllers;

use App\Jobs\AiFoodJob;
use App\Models\Content;
use App\Traits\StringToJson;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class FoodController extends Controller
{
    use StringToJson;
    public function ch() {
    $content = Content::findOrFail(44);
    $user = $content->user;
    $user->load('personality'); 
    // dd(Arr::except($user->personality->toArray(),['id','user_id','religion','created_at','updated_at']));

    $personality = $user->personality;

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
    $text = preg_replace('/\s+/','',$text);
    dd(trim($text));
    }
    public function creator() {
        $model = 'MealCreator';
        return view('foodAi.food',compact('model'));
    }

    public function analyzer() {
        $model = 'ProductAnalyzer';
        return view('foodAi.food',compact('model'));
    }

    public function make(Request $request) {
        $data = $request->validate([
            'model' => ['string','required','in:ProductAnalyzer,MealCreator'],
            'photo' => ['image','required'],
            'text' => ['max:200'],
        ]);
        if($request->hasFile('photo')) {
            // Handle image upload and optimization
            $fileName = Str::random(16) . time() . '.webp';
            $tempPath = $request->file('photo')->getRealPath();

            // تحسين الصورة باستخدام Intervention Image
            $image = Image::read($tempPath);

            // تصغير الحجم مع الحفاظ على النسبة
            $image->resize(150, 130, function ($constraint) {
                $constraint->aspectRatio(); // الحفاظ على النسبة
                $constraint->upsize(); // منع التكبير إذا كانت الصورة أصغر
            });

            // تحسين الجودة والضغط
            // $image->quality(75); // ضغط بنسبة 75%

            // حفظ الصورة بصيغة WebP في مجلد مؤقت
            $optimizedTempPath = sys_get_temp_dir() . '/' . $fileName;
            $image->save($optimizedTempPath, 'webp');

            // استخدام Spatie Image Optimizer لتحسين إضافي
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($optimizedTempPath);

            // قراءة الملف المحسن
            $optimizedContent = file_get_contents($optimizedTempPath);

            // حفظ الملف في التخزين
            if(!empty($path->image_path)) {
                Storage::delete('photos/' . $path->image_path);
            }
            Storage::put('photos/' . $fileName, $optimizedContent);

            // حذف الملف المؤقت
            if (file_exists($optimizedTempPath)) {
                unlink($optimizedTempPath);
            }
            $data['image_path'] =  $fileName;
        }
        $content = auth()->user()->contents()->create([
            'image_path' =>$data['image_path'],
            'title' => $data['text'],
            'type' => $data['model'],
        ]);
        // Dispatch Job AI Food
        // dump(storage_path('app/public/photos/' . $content->image_path));
        // dd(file_exists(storage_path('app/public/photos/' . $content->image_path)));
            AiFoodJob::dispatch($content);

        // broadcast(new AiResultDone($content));
        // return redirect()->route('content.show',$content->slug);
    }
}
