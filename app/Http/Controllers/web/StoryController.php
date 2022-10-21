<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\Story;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Models\Rate;
use Illuminate\Support\Facades\DB;

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

    public function ajax_rate(Request $request){
        $data = $request->all();
        $ip = $this->getIp();
        if ($data['star'] == 0 || $data['star'] > 5) $data['star'] = 5;
        $check = Rate::where('slug', $data['slug'])->where('ip', $ip)->count();
        if($check == 0){
            $vote = DB::select('select COUNT(1) AS count_vote, ROUND( AVG(vote),1) AS avg  from rate where slug = ?', [$data['slug']]);
            $vote = $vote[0];
            $count_vote = $vote->count_vote;
            $avg = ($vote->avg * $vote->count_vote + 5) / ($vote->count_vote + 1);
            $count_vote++;

            $resultVote = new \stdClass();
            $resultVote->count_vote = $count_vote;
            $resultVote->avg = $avg;

            //save vote

            $rate = new Rate();
            $rate->slug = $data['slug'];
            $rate->ip = $ip;
            $rate->vote = $data['star'];
            $rate->save();
            $message['type'] = 'success';
            $message['message'] = "Bạn vừa đánh giá {$data['star']} sao cho truyện này.";
            $message['vote'] = $resultVote;
            return \response()->json($message);
        }
        $message['type'] = 'warning';
        $message['message'] = "Bạn đã đánh giá bài truyện rồi.";
        return \response()->json($message);

    }
    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }
}
