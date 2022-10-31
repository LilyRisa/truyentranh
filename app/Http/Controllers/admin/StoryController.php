<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Request;
use Redirect;
use App\Models\Story;
use App\Models\Story_category;
use App\Models\Story_tag;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoryController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $limit = 10;
        $count = Story::count();
        $pagination = (int) ceil($count/$limit);
        #
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        #
        $condition = [];
        $condition_raw = null;
        if (isset($_GET['status'])) {
            $condition[] = ['status', $_GET['status']];
        }
        
        if (!empty($_GET['title'])) {
            $condition_raw = DB::raw('MATCH (title) AGAINST ("'.$_GET['title'].'")');
        }
        if(isset($_GET['is_home'])){
            if(!empty($_GET['is_home'])){
                $condition[] = ['is_home', $_GET['is_home']];
            }
            
        }
        if (!empty($_GET['time_range'])) {
            
            $date = explode(' - ',$_GET['time_range']);
            $date_start = date('Y-m-d H:i:s', strtotime($date[0]));
            $date_end = date('Y-m-d H:i:s', strtotime($date[1]));        
            $condition[] = ['created_at','>=', $date_start];
            $condition[] = ['created_at','<=', $date_end];
        }
        // dd($condition);
        #
        $data['categoryTree'] = Category::getTree(0);
        $data['listUser'] = User::where('status', 1)->get();
        #
        if (!empty($_GET['category_id'])) {
            $cate_id = (int)$_GET['category_id'];
            $listItem = Story::with(['categories', 'chapter'])->whereHas('categories', function($q) use ($cate_id){
                return $q->where('story_category.category_id', $cate_id)->where('story_category.is_primary', 1);
            })->where($condition)->orderBy('created_at', 'DESC')->offset(($page-1)*$limit)->limit($limit);
        }else{
            $listItem = Story::with(['categories', 'chapter'])->whereHas('categories', function($q){
                return $q->where('story_category.is_primary', 1);
            })->where($condition)->orderBy('created_at', 'DESC')->offset(($page-1)*$limit)->limit($limit);
        }

        if($condition_raw){
            $listItem = $listItem->whereRaw($condition_raw)->get();
            $data['total'] = Story::where($condition)->whereRaw($condition_raw)->count();
        }else{
            $listItem = $listItem->get();
            $data['total'] = Story::where($condition)->count();
        }
        // foreach ($listItem as $key => $item) {
        //     $listItem[$key]->count_link_ve = InternalLink::where('post_id_out', $item->id)->count();
        // }
        $data['listItem'] = $listItem;
        $data['pagination'] = $pagination;
        $data['page'] = $page;
        return view('admin.story.index', $data);
    }

    public function update($id = 0) {
        $data['url_referer'] = Request::server('HTTP_REFERER') ?? '/admin/story?status=1';
        $data['categoryTree'] = Category::getTree(0);
        $data['user_id'] = Auth::id();
        $data['level_id'] = Auth::user()->level_id;

        if ($id > 0) {
            $data['oneItem'] = $oneItem = Story::with('categories')->findOrFail($id);
            $data['optional'] = json_decode($oneItem->optional);
        }
        if (!empty(Request::post())) {
            $story_data = Request::post();
            $url_referer = $story_data['url_referer'];
            unset($story_data['url_referer']);
            if (empty($story_data['slug'])) $story_data['slug'] = toSlug($story_data['title']);
  
            if (!empty($story_data['tag'])) {
                $story_tag = $story_data['tag'];
                unset($story_data['tag']);
            }
            if (!empty($story_data['category'])) {
                $story_category = $story_data['category'];
                unset($story_data['category']);
            }

            Story::updateOrInsert(['id' => $id], $story_data);
            if (!empty($story_tag)) {
                if ($id > 0)
                    Story_tag::where('story_id', $id)->delete();
                else
                    $id = DB::getPdo()->lastInsertId();
                foreach ($story_tag as $item) {
                    Story_tag::insert(['story_id' => $id, 'tag_id' => $item]);
                }
            }
            if (!empty($story_category)) {
                if ($id > 0)
                    Story_category::where('story_id', $id)->delete();
                else
                    $id = DB::getPdo()->lastInsertId();
                foreach ($story_category as $key => $item) {
                    if ($key == 0)
                        Story_category::insert(['story_id' => $id, 'category_id' => $item, 'is_primary' => 1]);
                    else
                        Story_category::insert(['story_id' => $id, 'category_id' => $item]);
                }
            }
            if ($id == 0) $id = DB::getPdo()->lastInsertId();
            if (!empty($category_id)) {
                Story_category::where('story_id', $id)->delete();
                Story_category::insert(['story_id' => $id, 'category_id' => $category_id]);
            }

            // InternalLink::updateData($id, $post_data['content']);

            return Redirect::to($url_referer);
        }
        return view('admin.story.update', $data);
    }

    public function delete($id) {
        Story::destroy($id);
        //Post_tag::where('post_id', $id)->delete();
        Story_category::where('story_id', $id)->delete();
        return back();
    }
}
