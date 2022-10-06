<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ShortLink;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\Post;
use Cache;

use App\Service\GoogleApi;
class HomeController extends Controller
{
    public function index() {
        $data = [];
        // $data['count_post_dash'] = Cache::remember('count_post_dash', now()->addMonth(1), function () {
        //     return Post::all()->count();
        // });
        // $char_count_post = $this->getCountPostMonth();
        // $data['cout_post_new'] = $char_count_post[date('m')];
        // $data['cout_post_old'] = $char_count_post[date('m', strtotime(date('Y-m-d H:i:s').'-1 months'))];
        // if($data['cout_post_new'] >= $data['cout_post_old']){
        //     $data['percent_post'] = $this->round_up(($data['cout_post_new'] / $data['cout_post_old']) * 100, 2);
        // }else{
        //     $data['percent_post'] = -$this->round_up(($data['cout_post_new'] / $data['cout_post_old']) * 100, 2);
        // }
        // $data['char_count_post'] = [];
        // foreach($char_count_post as $key => $cc){
        //     $data['char_count_post'][] = [
        //         'month' => $key,
        //         'count' => $cc,
        //     ];
        // }
        // $user_traffic = GoogleApi::init()->addScope('analytics')->initializeAnalytics()->getFirstProfileId()->getResults();
        // $user_traffic = !empty($user_traffic->rows) ? $user_traffic->rows[0][0] : 0;

        // $data['user_traffic'] = $user_traffic;

        // $realtime = GoogleApi::init()->addScope('analytics')->getRealtimeUser();
        // $data['realtime'] = [];
        // if(!empty($realtime->rows)){
        //     foreach($realtime->rows as $d){
        //         $data['realtime'][] = [
        //             'country' => $d->dimensionValues[0]->value,
        //              'count' => $d->metricValues[0]->value,
        //         ];
        //     }
        // }
        

        // $hehe = GoogleApi::init()->addScope('analytics')->getRealtimeUser();
        // dd($hehe);
        return view('admin.home.index', $data);
    }


    private function getCountPostMonth(){

        if(Cache::has('getCountPostMonth')){
            return Cache::get('getCountPostMonth');
        }
        $arr_month = [];
        $arr_month[] = date('m');
        $arr_month_count = [];
        for($i = 1; $i <= 6; $i++){
            $arr_month[] = date('m', strtotime(date('Y-m-d H:i:s').'-'.$i.' months'));
        }

        foreach($arr_month as $mt){
            $date_start = date('Y').'-'.$mt.'-01';
            $date_end = date('Y').'-'.$mt.'-'.date('t');
            $arr_month_count[$mt] = Post::where('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_end)))->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_start)))->count();
        }
        Cache::set('getCountPostMonth', $arr_month_count, now()->addHours(12));
        return $arr_month_count;

        
    }

    private function round_up ($value, $places=0) {
        if ($places < 0) { $places = 0; }
        $mult = pow(10, $places);
        return ceil($value * $mult) / $mult;
      }

    public function cache_clear(){
        Artisan::call('cache:clear');
        echo 'Đã Xóa thành công!';
        return;
    }

    public function shorturl(Request $request){
        $url = $request->input('url');
        $url_gen = substr(base_convert(md5($url), 16,32), 0, 12);
        $link = ShortLink::where('slug_gen', $url_gen)->first();
        if(!empty($link)){
            return response()->json(['url_new' => $url_gen]);
        }
        $link = new ShortLink();
        $link->slug_original = $url;
        $link->slug_gen = $url_gen;
        $link->save();
        return response()->json(['url_new' => $url_gen]);
    }
}
