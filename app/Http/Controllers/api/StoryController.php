<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\ApiController;
use App\Models\Story;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Redirect;

class StoryController extends ApiController
{

    public function index(Request $request){
        $page = (int)$request->get('page', 1);
        $limit = (int)$request->get('limit', 10);

        $data = Story::limit($limit)->offset(($page-1)*$limit)->orderBy('created_at', 'DESC')->get();
        $count = count($data);

        return \response()->json(['count' => $count, 'data' => $data]);
    }

    public function getone($id){

        $data = Story::where('id', $id)->first();
        return \response()->json($data);
    }

    public function chapter(Request $request, $story_id){
        $orderby = $request->get('orderby', 'DESC');
        $data = Chapter::with('story')->where('story_id', $story_id)->orderBy('id', $orderby)->get()->toArray();
        $count = count($data);
        $data = array_map(function($item){
            $item['content'] = str_replace('src="//', 'src="'.\Config::get('app.url').'/img-proxy=//', $item['content']);
            return $item;
        },$data);

        return \response()->json(['count' => $count, 'data' => $data]);
    }
}
