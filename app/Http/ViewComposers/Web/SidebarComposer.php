<?php

namespace App\Http\ViewComposers\Web;

use App\Models\Football_league;
use App\Models\Tag;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\Page;
use App\Models\Category;
use App\Models\Rate;
use Illuminate\Support\Facades\DB;
use Cache;
class SidebarComposer
{
    public function compose(View $view)
    {
        $data['categoryTree'] = Category::getTree(1);

        if(Cache::has('new_post_sidebar-id-desc-limit-5')){
            $data['new_post'] = Cache::get('new_post_sidebar-id-desc-limit-5');
        }else{
            $data['new_post'] = Post::where('status', 1)->orderBy('id', 'desc')->limit(5)->get();
            Cache::set('new_post_sidebar-id-desc-limit-5', $data['new_post'], now()->addHours(12));
        }
        if(Cache::has('tag::all()')){
            $data['tag'] = Cache::get('tag::all()');
        }else{
            $data['tag'] = Tag::all();
            Cache::set('tag::all()', $data['tag'], now()->addHours(12));
        }

        // get random page exclude (Liên hệ)
        if(Cache::has('page_side_bar_with_user_exclude')){
            $data['page_rd'] = Cache::get('page_side_bar_with_user_exclude');
        }else{
            $data['page_rd'] = Page::with('user')->whereNotIn('slug', ['lien-he'])->inRandomOrder()->limit(3)->get();
            Cache::set('page_side_bar_with_user_exclude', $data['page_rd'], now()->addHours(12));
        }

        // get post rate highest
        Cache::forget('get_post_rate_highest');
        if(Cache::has('get_post_rate_highest')){
            $data['post_rate_highest'] = Cache::get('get_post_rate_highest');
        }else{
            $post = Post::orderBy('displayed_time', 'DESC')->get();
            $higest = [];
            foreach($post as &$pt){
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


            $higest = array_slice($higest, 0, 3);

            usort($higest, function($a, $b){
                return $a->count_vote_avg < $b->count_vote_avg;
            });
             // limit 5
            usort($higest, function($a, $b){
                return strtotime($a->displayed_time) < strtotime($b->displayed_time);
            });
            $data['post_rate_highest'] = $higest;
            Cache::set('get_post_rate_highest', $data['post_rate_highest'], now()->addHours(24));
        }

        $view->with($data);
    }
}
