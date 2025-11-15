<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenFoodFacts\Api;

class UserController extends Controller
{
    public function __invoke()
    {
        // brands
        // product_name
        // $api = new Api('food');
        // $product = $api->getProduct('3057640385148');
        // dd($product);
        return view('user');
    }
}
