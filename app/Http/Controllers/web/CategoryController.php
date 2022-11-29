<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\Story_category;
use App\Models\Category;
use App\Models\Post;
use App\Models\Post_Category;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function index($slug, $id, $page = 1)
    {
        $oneItem = Category::find($id);
        if (empty($oneItem) || $oneItem->status == 0)
            return Redirect::to(url('/'));
        $data['oneItem'] = $oneItem;
        if ($oneItem->slug != $slug) return Redirect::to(getUrlCate($oneItem), 301);
        $data['seo_data'] = initSeoData($oneItem, 'category');

        $data['loadmore'] = true;

        $limit = 10;
        $condition = [];
        $orderBy = '';
        $status = '';
        $check = [];
        if (isset($_GET['sort'])) {
            $check['sort'] = $_GET['sort'];
        }
        if (isset($_GET['status_category'])) {
            $check['status_cate'] = $_GET['status_category'];
        }
        
        if(!empty($check))
        {
            if(!empty($check['sort']))
            {
                switch ($check['sort']) {
                    case 'alphabet':
                        $orderBy = "title";
                        break;
                    case 'view':
                        $orderBy = "view_count";
                        break;
                    case 'rate':
                        $orderBy = "views";
                        break;
                    case 'chapter':
                        $orderBy = "chapter";
                        break;
                    default:
                        break;
                };
            }

            if(!empty($check['status_category']))
            {
                switch ($check['status_category']) {
                    case 'all':
                        $status = "";
                        break;
                    case 'new_up':
                        $status = "updated_at";
                        break;
                    case 'done':
                        $status = ['is_update','Hoàn thành'];
                        break;
                    case 'in_process':
                        $status = ['is_update','Đang tiến hành'];
                        break;
                    default:
                        break;
                };
            }


        }

    
        $params = [
            'info_category' => true,
            'category_id' => $id,
            'limit' => $limit,
            'offset' => ($page - 1) * $limit,
            'chapter' => true,
            'order_by' => $orderBy,
            'status' => $status
        ];

        if($orderBy == '')
        {
            unset($params["order_by"]);
        }

        if($status == '')
        {
            unset($params["status"]);
        }
   

        if ($oneItem->category_post == 1) {
            unset($params['capter']);
        }

        if (isset($_GET['title'])) {
            $params['title'] = $_GET['title'];
            $data['search_title'] = $_GET['title'];
        }

        if (isset($_GET['order_by'])) {
            $params['order_by'] = $_GET['order_by'];
        }

        if (isset($_GET['status'])) {
            $params['status'] = $_GET['status'];
        }

        if ($oneItem->category_post == 1) {
            $count = Post::getCount($params);
            if ($count <= $limit) $data['loadmore'] = false;
            $count = Post::getCount($params);
            $pagination = (int) ceil($count / $limit);
            $data['pagination'] = $pagination;
            $data['page'] = $page;

            $data['posts'] = Post::getPosts($params);

            $data['listCategory'] = Category::where('category_post', 1)->get();
        } else {
            $count = Story::getCount($params);
            if ($count <= $limit) $data['loadmore'] = false;
            $count = Story::getCount($params);
            $pagination = (int) ceil($count / $limit);
            $data['pagination'] = $pagination;
            $data['page'] = $page;

            $data['story'] = Story::getStorys($params);

            $data['listCategory'] = Category::where('category_post', 0)->get();
        }

        $breadCrumb = [];
        $breadCrumb[] = [
            'name' => $oneItem->title,
            'item' => getUrlCate($oneItem),
            'schema' => true,
            'show' => true
        ];

        $data['breadCrumb'] = $breadCrumb;


        if ($oneItem->category_post == 1) {
            return view('web.category.blog', $data);
        }

        return view('web.category.index', $data);
    }

    public function blog()
    {
        return view('web.category.blog');
    }
}
