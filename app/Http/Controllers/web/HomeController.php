<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Story;

class HomeController extends Controller
{   
    public function index()
    {
        $data['new'] = Story::with(['categories', 'chapter'])->whereHas('chapter', function($q){
            return $q->orderBy('id','DESC');
        })->orderBy('created_at', 'DESC')->limit(12)->get();
        return view('web.home.index', $data);
    }
}
