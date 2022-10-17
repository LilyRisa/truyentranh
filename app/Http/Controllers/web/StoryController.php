<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\Story;
use App\Models\Chapter;

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
        $data['oneItem'] = $oneItem = Chapter::with(['story' => function($q){
            return $q->with('categories');
        }])->where('slug', $slug)->where('id', $id)->first();
        if(empty($data['oneItem'])) return Redirect::to(getUrlStory(['slug' => $slug]), 301);

        $data['list'] = $list = Chapter::where('story_id', $data['oneItem']->story->id)->orderBy('id', 'DESC')->get();

        $data['before'] = null;
        $data['after'] = null;

        foreach($list as $k => $v){
            if($v->id == $oneItem->id){
                if($k == 0){
                    $data['after'] = $list[1];
                }else if($k == (count($list) -1)){
                    $data['before'] = $list[$k - 1];
                }else{
                    $data['before'] = $list[$k - 1];
                    $data['after'] = $list[$k + 1];
                }
            }
        }
        return view('web.chapter.index', $data);
    }
}
