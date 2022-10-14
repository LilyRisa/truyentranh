<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\Story;

class StoryController extends Controller
{   
    public function index($slug, $id)
    {
        if($id == 0){
            return $this->story($slug);
        }
        return $this->chapter($slug, $id);
    }
    private function story($slug){
        
        $data['oneItem'] = $oneItem = Story::with(['categories', 'chapter', 'tags'], function($q){
            return $q->orderBy('id', 'DESC');
        })->where('slug', $slug)->first();

        if(empty($oneItem)) return Redirect::to(url('/'), 301);
        return view('web.story.index', $data);
    }
    private function chapter($slug, $id){

    }
}
