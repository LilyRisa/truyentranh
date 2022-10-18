<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\ApiController;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Category;
use Illuminate\Http\Request;
use Redirect;

class CategoryController extends ApiController
{

    public function index(Request $request){
        $page = (int)$request->get('page', 1);
        $limit = (int)$request->get('limit', 10);

        $data = Category::limit($limit)->offset(($page-1)*$limit)->orderBy('created_at', 'DESC')->get();
        $count = count($data);

        return \response()->json(['count' => $count, 'data' => $data]);
    }

    public function getone($id){
        $data = Category::where('id', $id)->first();
        return \response()->json($data);
    }

    public function gettype(Request $request, $id, $type){

        $page = (int)$request->get('page', 1);
        $limit = (int)$request->get('limit', 10);

        if($type == 'story'){
            
            $data = Category::with(['story' => function($q) use($page, $limit){
                return $q->limit($limit)->offset(($page -1) *$limit);
            }])->where('id', $id)->first();

            $data_story = $data->story;
            $count = count($data_story);
            return \response()->json(['count' => $count, 'data' => $data_story]);
        }
        if($type == 'post'){
            $data = Category::with(['post' => function($q) use($page, $limit){
                return $q->limit($limit)->offset(($page -1) *$limit);
            }])->where('id', $id)->first();
            $data_post = $data->post;
            $count = count($data_post);
            return \response()->json(['count' => $count, 'data' => $data_post]);
        }
        return \response()->json(['count' => 0, 'data' => null]);
    }

}
