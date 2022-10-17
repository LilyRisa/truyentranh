<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{   
    public function index()
    {
        return view('web.category.index');
    }

    public function blog()
    {
        return view('web.category.blog');
    }
}
