<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\InternalLink;
use App\Models\Match;
use App\Models\User;
use Request;
use Redirect;
use App\Models\Video;
use App\Models\Category;
use App\Models\Video_tag;
use App\Models\Video_Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $limit = 10;
        $count = Video::count();
        $pagination = (int) ceil($count/$limit);
        #
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        #
        $condition = [];
        if (isset($_GET['is_status'])) {
            $condition[] = ['is_status', $_GET['is_status']];
        }
        if (!empty($_GET['hen_gio'])) {
            $condition[] = ['displayed_time', '>', Video::raw('NOW()')];
        } elseif (!empty($_GET['status'])) {
            $condition[] = ['displayed_time', '<=', Video::raw('NOW()')];
        }
        if (!empty($_GET['keyword'])) {
            $condition[] = ['slug', 'LIKE', '%'.toSlug($_GET['keyword']).'%'];
        }
        if (!empty($_GET['category_id'])) {
            $condition[] = ['category_id', $_GET['category_id']];
        }
        if (!empty($_GET['user_id'])) {
            $condition[] = ['user_id', $_GET['user_id']];
        }
        #
        $data['categoryTree'] = Category::getTree();
        $data['listUser'] = User::where('status', 1)->get();
        #
        $listItem = Video::where($condition)->orderBy('displayed_time', 'DESC')->offset(($page-1)*$limit)->limit($limit)->get();
        $data['total'] = Video::where($condition)->count();
        foreach ($listItem as $key => $item) {
            $listItem[$key]->count_link_ve = InternalLink::where('post_id_out', $item->id)->count();
        }
        $data['listItem'] = $listItem;
        $data['pagination'] = $pagination;
        $data['page'] = $page;
        return view('admin.post.video', $data);
    }

    public function update($id = 0) {
        $data['url_referer'] = Request::server('HTTP_REFERER') ?? '/admin/post?status=1';
        $data['categoryTree'] = Category::getTree();
        $data['user_id'] = Auth::id();
        $data['group_id'] = Auth::user()->group_id;

        if ($id > 0) {
            $data['oneItem'] = $oneItem = Video::findOrFail($id);
            $data['optional'] = json_decode($oneItem->optional);
            if (!empty($oneItem->id_bongdalu))
                $data['match'] = Match::where('id_bongdalu', $oneItem->id_bongdalu)->get()->first();
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
                $post_data['category_id'] = $post_category[0];
            }
            if (!empty($post_data['optional']))
                $post_data['optional'] = json_encode($post_data['optional']);

            if (!empty($post_data['id_bongdalu']))
                Match::updateOrInsert(['id_bongdalu' => $post_data['id_bongdalu']], $post_data['match']);
            unset($post_data['match']);

            Video::updateOrInsert(['id' => $id], $post_data);
            if (!empty($post_tag)) {
                if ($id > 0)
                    Video_tag::where('video_id', $id)->delete();
                else
                    $id = DB::getPdo()->lastInsertId();
                foreach ($post_tag as $item) {
                    Video_tag::insert(['video_id' => $id, 'tag_id' => $item]);
                }
            }
            if (!empty($post_category)) {
                if ($id > 0)
                    Video_Category::where('video_id', $id)->delete();
                else
                    $id = DB::getPdo()->lastInsertId();
                foreach ($post_category as $key => $item) {
                    if ($key == 0)
                    Video_Category::insert(['video_id' => $id, 'category_id' => $item]);
                    else
                    Video_Category::insert(['video_id' => $id, 'category_id' => $item]);
                }
            }
            if ($id == 0) $id = DB::getPdo()->lastInsertId();
            if (!empty($category_id)) {
                Video_Category::where('video_id', $id)->delete();
                Video_Category::insert(['video_id' => $id, 'category_id' => $category_id]);
            }

            InternalLink::updateData($id, $post_data['content']);

            return Redirect::to($url_referer);
        }
        return view('admin.post.video_update', $data);
    }

    public function delete($id) {
        Video::destroy($id);
        //Post_tag::where('post_id', $id)->delete();
        Video_Category::where('video_id', $id)->delete();
        return back();
    }
}
