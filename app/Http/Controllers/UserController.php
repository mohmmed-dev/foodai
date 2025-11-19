<?php

namespace App\Http\Controllers;

use App\Events\AiResultDone;
use App\Models\Content;
use Illuminate\Http\Request;
use OpenFoodFacts\Api;

class UserController extends Controller
{
    public function __invoke()
    {
         $content = Content::find(1);
         AiResultDone::dispatch($content);
        // broadcast(new AiResultDone($content));
        // brands
        // product_name
        // $api = new Api('food');
        // $product = $api->getProduct('3057640385148');
        // dd($product);
        return view('contents.show', compact('content'));
    }
}
