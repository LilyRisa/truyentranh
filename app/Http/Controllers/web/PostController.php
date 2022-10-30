<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\Rate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Level;
use Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;
use Cache;

use App\Service\InterLink;

class PostController extends Controller
{
    public function index($slug, $id) {
        $data['page'] = $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $oneItem = Post::with(['categories','user', 'tags'])->where('id',$id)->first();
        if (empty($oneItem) || $oneItem->status == 0 || strtotime($oneItem->displayed_time) > time())
        {
            $user = Auth::user();
            if(empty($user)){
                 return Redirect::to(url('/'), 301);
            }
                
            $Level = Level::find($user->Level_id);
            $permission = json_decode($Level->permission, 1);
            if(empty($permission['post']['index']))
                return Redirect::to(url('/'), 301);
        }
        // dd($oneItem);

        if(empty($oneItem)){
            return Redirect::to(url('/'), 301);
        }

        if ($oneItem->slug != $slug) return Redirect::to(getUrlPost($oneItem), 301);
        $oneItem->content = InterLink::init()->setContent($this->parse_content($oneItem->content))->get()->content;

        $data['category'] = $category = Category::find($oneItem->category_primary_id);

        //$data['tag'] = Post_tag::leftjoin('tag', 'tag_id', '=', 'id')->where('post_id', $id)->get();
        $data['limit'] = $limit  = 4;
        $data['related_post'] = Post::with('Category')->where(['status' => 1, 'category_primary_id' => $oneItem->category_id, ['displayed_time', '<=', Post::raw('NOW()')], ['id', '<>', $id]])->orderBy('displayed_time', 'DESC')->offset(($page-1)*4)->limit($limit)->get();
        // dd($data['related_post']);
//        if (!empty($oneItem->id_bongdalu))
        $data['related_post'] = Post::with('Category')->where(['status' => 1, 'category_primary_id' => $oneItem->category_id, ['displayed_time', '<=', Post::raw('NOW()')], ['id', '<>', $id]])->orderBy('displayed_time', 'DESC')->limit(4)->get();
        $data['seo_data'] = initSeoData($oneItem, 'post');
        // $data['seo_data']['amp_facebook_cmt'] = true;
        $data['seo_data']['rating_amp'] = true;

        $breadCrumb = [];

        $breadCrumb[] = [
            'name' => $category->title,
            'item' => getUrlCate($category),
            'schema' => false,
            'show' => true
        ];
        $breadCrumb[] = [
            'name' => $oneItem->title,
            'item' => getUrlPost($oneItem),
            'schema' => true,
            'show' => false
        ];

        $data['breadcrumb'] = $breadCrumb;

        $data['user'] = $user = User::where('id',$oneItem->user_id)->first();

        $data['schema'] = getSchemaBreadCrumb($breadCrumb).getSchemaArticle($oneItem, $user);
        $date = date('Y-m-d H:i:s l');
        $date = strtotime($date);
        $weekday = date("l");
	    $weekday = strtolower($weekday);
        switch($weekday) {
            case 'monday':
                $weekday = 'Thứ hai';
                break;
            case 'tuesday':
                $weekday = 'Thứ ba';
                break;
            case 'wednesday':
                $weekday = 'Thứ tư';
                break;
            case 'thursday':
                $weekday = 'Thứ năm';
                break;
            case 'friday':
                $weekday = 'Thứ sáu';
                break;
            case 'saturday':
                $weekday = 'Thứ bảy';
                break;
            default:
                $weekday = 'Chủ nhật';
                break;
        }
        $data['time'] = $weekday.', Ngày '.date('d/m/Y - h:m',$date);
        $data['oneItem'] = $oneItem;

        // đọc thêm
        
        
        $cache_post_more = md5('postmore-keyword-'.$oneItem->meta_keyword);
        if(Cache::has($cache_post_more)){
            $data['more_post'] = Cache::get($cache_post_more, now()->addHours(12));
        }else{
            $keyword = explode(',', $oneItem->meta_keyword);
            $more_post = Post::whereNotIn('id',[$id])->where(function($q) use ($keyword){
                if(!empty($keyword)){
                    foreach($keyword as $key => $kw){
                        $kwv = str_replace('/\s+/','',$kw);
                        $q->orWhere('meta_keyword', 'like', '%'.$kwv.'%');
                    }
                }
            });
            $data['more_post'] = $more_post->orderBy('displayed_time', 'DESC')->limit(5)->get();
            Cache::set($cache_post_more, $data['more_post']);
        }
        

        if(IS_AMP) return view('web.post.amp-index', $data);

        return view('web.post.index', $data);
    }


    public function ampIndex($slug, $id){
        return $this->index($slug, $id);
    }

    private function parse_content($content) {
        return $content;
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
            $message['message'] = "Bạn vừa đánh giá {$data['star']} sao cho bài viết này.";
            $message['vote'] = $resultVote;
            return \response()->json($message);
        }
        $message['type'] = 'warning';
        $message['message'] = "Bạn đã đánh giá bài viết này rồi.";
        return \response()->json($message);

    }

    public function ajax_load_more_post_amp(){
        turnOnAjaxAmp();
        $dataPost = $_GET;

        $category_id = $dataPost['category_id'] ?? die();
        $limit = $dataPost['limit'] ?? die();
        $page = $dataPost['page'] ?? die();

        $data = Post::where(['status' => 1, 'category_id' => $category_id, ['displayed_time', '<=', Post::raw('NOW()')]])
            ->orderBy('displayed_time', 'DESC')
            ->offset(($page-1)*$limit)
            ->limit($limit + 1)
            ->get()->toArray();

        foreach ($data as &$a){
            $cateItem = Category::getById($a['category_id']);
            $a['category_slug'] = getUrlCate($cateItem);
            $a['category_title'] = $cateItem->title;

            $a['description'] = !empty($a['description']) ? $a['description'] : get_limit_content($a['content'], 200);
            $a['slug'] = getUrlPost($a, 1);
        }

        $dataReturn = array_splice($data, 0, $limit);
        $checkLoadMore = count($data);

        $next = '';
        if ($checkLoadMore){
            $next = url("/ajax-load-more-post-amp?category_id=$category_id&limit=$limit&page=".++$page);
        }

        return \Response::json(['items' => $dataReturn, 'next' => $next]);
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