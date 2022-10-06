<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\InternalLink;
use App\Models\Match;
use App\Models\User;
use Request;
use Redirect;
use App\Models\Post;
use App\Models\Category;
use App\Models\Post_tag;
use App\Models\Post_Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $limit = 10;
        $count = Post::count();
        $pagination = (int) ceil($count/$limit);
        #
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        #
        $condition = [];
        if (isset($_GET['status'])) {
            $condition[] = ['status', $_GET['status']];
        }
        if (!empty($_GET['hen_gio'])) {
            $condition[] = ['displayed_time', '>', Post::raw('NOW()')];
        } elseif (!empty($_GET['status'])) {
            $condition[] = ['displayed_time', '<=', Post::raw('NOW()')];
        }
        if (!empty($_GET['keyword'])) {
            $condition[] = ['slug', 'LIKE', '%'.toSlug($_GET['keyword']).'%'];
        }
        if (!empty($_GET['category_id'])) {
            $condition[] = ['category_primary_id', $_GET['category_id']];
        }
        if (!empty($_GET['user_id'])) {
            $condition[] = ['user_id', $_GET['user_id']];
        }
        if (!empty($_GET['title'])) {
            $condition[] = ['title','LIKE', '%'.$_GET['title'].'%'];
        }
        if (!empty($_GET['time_range'])) {
            
            $date = explode(' - ',$_GET['time_range']);
            $date_start = $date[0];
            $date_end = $date[1];

            $condition[] = ['created_at','>=', $date_start];
            $condition[] = ['created_at','<=', $date_end];
        }
        #
        $data['categoryTree'] = Category::getTree();
        $data['listUser'] = User::where('status', 1)->get();
        #
        $listItem = Post::with('category')->where($condition)->orderBy('displayed_time', 'DESC')->offset(($page-1)*$limit)->limit($limit)->get();
        $data['total'] = Post::where($condition)->count();
        // foreach ($listItem as $key => $item) {
        //     $listItem[$key]->count_link_ve = InternalLink::where('post_id_out', $item->id)->count();
        // }
        $data['listItem'] = $listItem;
        $data['pagination'] = $pagination;
        $data['page'] = $page;
        return view('admin.post.index', $data);
    }

    public function update($id = 0) {
        $data['url_referer'] = Request::server('HTTP_REFERER') ?? '/admin/post?status=1';
        $data['categoryTree'] = Category::getTree();
        $data['user_id'] = Auth::id();
        $data['group_id'] = Auth::user()->group_id;

        if ($id > 0) {
            $data['oneItem'] = $oneItem = Post::findOrFail($id);
            $data['optional'] = json_decode($oneItem->optional);
        }
        if (!empty(Request::post())) {
            $post_data = Request::post();
            $url_referer = $post_data['url_referer'];
            unset($post_data['url_referer']);
            if (empty($post_data['slug'])) $post_data['slug'] = toSlug($post_data['title']);
            /*$post_data['count_link_out'] = getNumberLinkOut($post_data['content']);*/
            if (!empty($post_data['tag'])) {
                $post_tag = $post_data['tag'];
                unset($post_data['tag']);
            }
            if (!empty($post_data['category'])) {
                $post_category = $post_data['category'];
                unset($post_data['category']);
                $post_data['category_primary_id'] = $post_category[0];
            }
            if (!empty($post_data['optional']))
                $post_data['optional'] = json_encode($post_data['optional']);

            Post::updateOrInsert(['id' => $id], $post_data);
            if (!empty($post_tag)) {
                if ($id > 0)
                    Post_tag::where('post_id', $id)->delete();
                else
                    $id = DB::getPdo()->lastInsertId();
                foreach ($post_tag as $item) {
                    Post_tag::insert(['post_id' => $id, 'tag_id' => $item]);
                }
            }
            if (!empty($post_category)) {
                if ($id > 0)
                    Post_Category::where('post_id', $id)->delete();
                else
                    $id = DB::getPdo()->lastInsertId();
                foreach ($post_category as $key => $item) {
                    if ($key == 0)
                        Post_Category::insert(['post_id' => $id, 'category_id' => $item, 'is_primary' => 1]);
                    else
                        Post_Category::insert(['post_id' => $id, 'category_id' => $item]);
                }
            }
            if ($id == 0) $id = DB::getPdo()->lastInsertId();
            if (!empty($category_id)) {
                Post_Category::where('post_id', $id)->delete();
                Post_Category::insert(['post_id' => $id, 'category_id' => $category_id]);
            }

            // InternalLink::updateData($id, $post_data['content']);

            return Redirect::to($url_referer);
        }
        return view('admin.post.update', $data);
    }

    public function delete($id) {
        Post::destroy($id);
        //Post_tag::where('post_id', $id)->delete();
        Post_Category::where('post_id', $id)->delete();
        return back();
    }
}
