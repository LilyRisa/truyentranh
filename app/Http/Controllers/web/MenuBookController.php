<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;

class MenuBookController extends Controller
{   
    public function index()
    {
        return view('web.menubook.index');
    }
}
