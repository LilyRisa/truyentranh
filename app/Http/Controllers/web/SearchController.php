<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;
use stdClass;

class SearchController extends Controller
{   
    public function story($search){
        $param = [
            'limit' => 10,
            'info_category' =>true,
            'offset' => 0,
            'title' => $search
        ];
        $dataraw = Story::getStorys($param)->toArray();
        $data = [];
        foreach($dataraw as $item){
            $set = new \stdClass;
            $set->url = getUrlStory($item);
            $set->category = new \stdClass;
            $set->category->title = $item['categories'][0]['title'];
            $set->image = $item['thumbnail'];
            $set->title = $item['title'];
            $set->descriptions = $item['description'];
            $data[] = $set;
            // $data[$item['categories'][0]['slug']]['name'] = $item['categories'][0]['title'];
            // $data[$item['categories'][0]['slug']]['results'][] = $set;
        }
        // dd($data);
        // $result = new \stdClass;
        // $result->results = new \stdClass;
        // foreach($data as $ky => $it){
        //     $result->results->{$ky} = $it;
        // }
        return \response()->json($data);
    }
}
