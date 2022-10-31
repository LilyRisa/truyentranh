<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Cookie;

class HomeController extends Controller
{   
    public function index()
    {

        //list tất cả category
        $key = md5('home_category_list');
        if(Cache::has($key)){
            $data['category'] = Cache::get($key);
        }else{
            $cate = Category::getTree(0);
            $cate2 = Category::getTree(1);
            
            $data['category'] = array_merge($cate, $cate2);
            Cache::set($key, $data['category'], now()->addHours(24));
        }

        $key = md5('home_new');
        if(Cache::has($key)){
            $data['new'] = Cache::get($key);
        }else{
            $data['new'] = Story::with(['categories', 'chapter'])->orderBy('updated_at', 'DESC')->limit(12)->get();
            Cache::set($key, $data['new'], now()->addHours(12));
        }

        //truyện lượt xem cao nhất
        $key = md5('home_story_view_highest');
        if(Cache::has($key)){
            $data['view_hight'] = Cache::get($key);
        }else{
            $data['view_hight'] = Story::with(['categories', 'chapter'])->orderBy('view_count', 'DESC')->limit(10)->get()->map(function ($query) {
                $query->setRelation('chapter', $query->chapter->take(1));
                return $query;
            });
            Cache::set($key, $data['view_hight'], now()->addHours(24));
        }

        
        // menu
        $key = md5('home_menu_home');
        if(Cache::has($key)){
            $data['menu_home'] = Cache::get($key);
        }else{
            $data['menu_home'] = Menu::where('id', 3)->first();
            $data['menu_home'] = !empty($data['menu_home']) ? json_decode($data['menu_home']->data) : null;
            Cache::set($key, $data['menu_home'], now()->addHours(24));
        }


        // nổi bật 
        $key = md5('story_feature-with-category-user-displayed_time-desc');
        if(Cache::has($key)){
            $data['story_feature'] = Cache::get($key);
        }else{
            $data['story_feature'] = Story::where('is_home', 1)->orderBy('created_at', 'DESC')->get();
            Cache::set($key, $data['story_feature'], now()->addHours(24));
        }

        // lấy bài truyện đang theo dõi

        $follow = $_COOKIE['story_follow'] ?? null ;
        $user_view = Cookie::get('story_user_view');
        if($follow){
            $follow = json_decode($follow);
            $data['follow_status'] = 'Truyện bạn đang theo dõi';
            $data['follow'] = Story::with(['categories', 'chapter'])->whereIn('id', $follow)->orderBy('created_at', 'DESC')->limit(10)->get();
        }else if($user_view){
            $user_view = json_decode($user_view);
            $data['follow_status'] = 'Truyện đã xem';
            $data['follow'] = [];
            foreach($user_view as $uv){
                $data['follow'][] = Story::with(['categories', 'chapter'])->where('id', $uv)->orderBy('created_at', 'DESC')->first();
            }
        }else{
            $key = md5('story_user_follow');
            $data['follow_status'] = 'Truyện có thể bạn quan tâm';
            if(Cache::has($key)){
                $data['follow'] = Cache::get($key);
            }else{
                $data['follow'] = Story::with(['categories', 'chapter'])->inRandomOrder()->limit(10)->get();
                Cache::set($key, $data['follow'], now()->addHours(24));
            }
            
        }

        // lấy truyện chuyên mục H
        $key = 'chuyen-muc-home-h+';
        if(Cache::has($key)){
            $data['category_h'] = Cache::get($key);
        }else{
            $data['category_h'] = Category::with(['story' => function($query){
                $query->orderBy('created_at', 'DESC')->limit(16);
            }])->where('id', 19)->first();
            $data['category_h'] = $data['category_h']->story;
            Cache::set($key, $data['category_h'], now()->addHours(24));
        }
        // get story rate highest
        // Cache::forget('get_story_rate_highest');
        if(Cache::has('get_story_rate_highest')){
            $data['get_story_rate_highest'] = Cache::get('get_story_rate_highest');
        }else{
            $data_slug = DB::table('rate')->select('slug')->groupBy('slug')->get()->toArray();
            $data_story = [];
            foreach($data_slug as $item){
                $data_story[] = $item->slug;
            }
            
            $story = Story::whereIn('slug',$data_story)->orderBy('created_at', 'DESC')->get();
            $higest = [];
            foreach($story as &$pt){
                $vote = DB::select('select COUNT(1) AS count_vote, ROUND( AVG(vote),1) AS avg  from rate where slug = ?', [$pt->slug]);
                $vote = $vote[0];
                $pt->count_vote = $vote->count_vote;
                $vote->avg = ($vote->avg*$vote->count_vote + 5) / ($vote->count_vote + 1);
                $count_vote = round($vote->avg, 1);
                $pt->count_vote_avg = $count_vote;
                $higest[] = clone $pt;
            }

            usort($higest, function($a, $b){
                return $a->count_vote < $b->count_vote;
            });


            $higest = array_slice($higest, 0, 10);

            usort($higest, function($a, $b){
                return $a->count_vote_avg < $b->count_vote_avg;
            });
             // limit 5
            // usort($higest, function($a, $b){
            //     return strtotime($a->displayed_time) < strtotime($b->displayed_time);
            // });
            $data['get_story_rate_highest'] = $higest;
            Cache::set('get_story_rate_highest', $data['get_story_rate_highest'], now()->addHours(24));
        }

        $data['breadCrumb'][0]['item'] = url('/');
        $data['schema'] = getSchemaLogo().getLocalBusiness();
        $data['seo_data'] = initSeoData(null,'home');
        return view('web.home.index', $data);
    }
}
