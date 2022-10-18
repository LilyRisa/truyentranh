<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;

class PostController extends Controller
{   
    public function index()
    {
        return view('web.post.index');
    }
}
