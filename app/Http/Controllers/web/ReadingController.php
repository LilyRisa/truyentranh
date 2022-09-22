<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;

class ReadingController extends Controller
{   
    public function index()
    {
        return view('web.book.index');
    }
}
