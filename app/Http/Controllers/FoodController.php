<?php

namespace App\Http\Controllers;

use App\Jobs\AiFoodJob;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class FoodController extends Controller
{

    public function ch() {
$jsonString = '
{
  "common": {
    "title": "Donuts",
    "description": "Stack of three donuts with chocolate and sprinkles",
    "allergens": [
      "Wheat",
      "Eggs",
      "Dairy",
      "Soy"
    ],
    "ingredients": [
      "Wheat flour",
      "Sugar",
      "Vegetable oil",
      "Eggs",
      "Milk",
      "Yeast",
      "Chocolate",
      "Sprinkles",
      "Soy lecithin",
      "Artificial flavors"
    ],
    "nutrition_facts": {
      "serving_size": "1 donut (approx. 70g)",
      "calories": "250-350",
      "total_fat": "12-18g",
      "saturated_fat": "5-8g",
      "cholesterol": "30-50mg",
      "sodium": "150-250mg",
      "total_carbohydrate": "30-40g",
      "dietary_fiber": "1-2g",
      "sugars": "15-20g",
      "protein": "3-5g"
    },
    "health_score": 30,
    "halal_compliance": {
      "summary_verdict": "UNCERTAIN",
      "details": "The Halal status is uncertain due to the presence of gelatin in the sprinkles and unspecified enzymes. The vegetable oil, artificial flavors and additives are also from unknown sources.",
      "halal_certified": false,
      "certifier_name": null
    }
  },
  "food_specific": {
    "personal_advice": "Consider this treat in moderation due to high sugar and fat content. Make sure it suits your current health goals.",
    "improvement_tips": "Opt for baked donuts instead of fried ones to reduce fat content. Use natural food coloring and sugar alternatives. Check the ingredients of the sprinkles to ensure they are gelatin-free.",
    "warnings": "High sugar and fat content may not be suitable for individuals with diabetes or heart conditions. May contain hidden allergens."
  }
}
';

// The standard PHP function to convert JSON to a PHP array
$dataArray = json_decode($jsonString, true);

// In Laravel, 'dump()' is used for debugging; in standard PHP, you'd use 'print_r' or 'var_dump'.
// If running in a Laravel environment:
dump($dataArray);



    $count = Content::findOrFail(40);
    dump(str_replace());
    }
    public function creator() {
        return view('foodAi.creator');
    }

    public function analyzer() {
        return view('foodAi.analyzer');
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
