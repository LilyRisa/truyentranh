<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Request;
use Redirect;
use App\Models\Chapter;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $limit = 10;
        $count = Chapter::count();
        $pagination = (int) ceil($count/$limit);
        #
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        #
        $condition = [];
       
        
        if (!empty($_GET['title'])) {
            $condition[] = ['title','LIKE', '%'.$_GET['title'].'%'];
        }
        if (!empty($_GET['time_range'])) {
            
            $date = explode(' - ',$_GET['time_range']);
            $date_start = date('Y-m-d H:i:s', strtotime($date[0]));
            $date_end = date('Y-m-d H:i:s', strtotime($date[1]));        
            $condition[] = ['created_at','>=', $date_start];
            $condition[] = ['created_at','<=', $date_end];
        }
       
        $listItem = Chapter::with('story')->where($condition)->orderBy('created_at', 'DESC')->offset(($page-1)*$limit)->limit($limit)->get();

        $data['total'] = Chapter::where($condition)->count();
     
        $data['listItem'] = $listItem;
        $data['pagination'] = $pagination;
        $data['page'] = $page;
        return view('admin.chapter.index', $data);
    }

    public function update($id = 0) {
        $data['url_referer'] = Request::server('HTTP_REFERER') ?? '/admin/chapter?status=1';
        $data['user_id'] = Auth::id();
        $data['level_id'] = Auth::user()->level_id;

        if ($id > 0) {
            $data['oneItem'] = $oneItem = Chapter::with('story')->findOrFail($id);
        }
        if (!empty(Request::post())) {
            $story_data = Request::post();
            $url_referer = $story_data['url_referer'];
            unset($story_data['url_referer']);

            $story_data['content'] = str_replace('src="/img-proxy=//','src="//',$story_data['content']);

            Chapter::updateOrInsert(['id' => $id], $story_data);
            
            if ($id == 0) $id = DB::getPdo()->lastInsertId();
        

            return Redirect::to($url_referer);
        }
        return view('admin.chapter.update', $data);
    }

    public function delete($id) {
        Chapter::destroy($id);
        return back();
    }
}
