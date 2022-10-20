<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\Menu;

class HomeController extends Controller
{   
    public function index()
    {
        $data['new'] = Story::with(['categories', 'chapter'])->whereHas('chapter', function($q){
            return $q->orderBy('id','DESC');
        })->orderBy('created_at', 'DESC')->limit(12)->get();

        // menu
        $data['menu_home'] = Menu::where('id', 3)->first();
        $data['menu_home'] = !empty($data['menu_home']) ? json_decode($data['menu_home']->data) : null;

        $data['breadCrumb'][0]['item'] = url('/');
        $data['schema'] = getSchemaLogo().getLocalBusiness();
        $data['seo_data'] = initSeoData(null,'home');
        
        return view('web.home.index', $data);
    }
}
