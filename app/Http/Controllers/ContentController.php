<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function __invoke(Content $content)
    {
        return view('contents.show',compact('content'));
    }
}
