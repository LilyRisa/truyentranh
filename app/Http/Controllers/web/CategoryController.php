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
        $data['seo_data'] = initSeoData($oneItem,'category');

        $data['loadmore'] = true;

        $limit = 10;

        $params = [
            'info_category' =>true,
            'category_id' => $id,
            'limit' => $limit,
            'offset' => ($page-1) * $limit,
            'chapter' => true,
        ];

        if($oneItem->category_post == 1){
            unset($params['capter']);
        }

        if(isset($_GET['title'])){
            $params['title'] = $_GET['title'];
            $data['search_title'] = $_GET['title'];
        }

        if(isset($_GET['order_by'])){
            $params['order_by'] = $_GET['order_by'];
        }

        if(isset($_GET['status'])){
            $params['status'] = $_GET['status'];
        }

        if($oneItem->category_post == 1){
            $count = Post::getCount($params);
            if($count <= $limit) $data['loadmore'] = false;
            $count = Post::getCount($params);
            $pagination = (int) ceil($count/$limit);
            $data['pagination'] = $pagination;
            $data['page'] = $page;

            $data['posts'] = Post::getPosts($params);

            $data['listCategory'] = Category::where('category_post', 1)->get();

        }else{
            $count = Story::getCount($params);
            if($count <= $limit) $data['loadmore'] = false;
            $count = Story::getCount($params);
            $pagination = (int) ceil($count/$limit);
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
        

        if($oneItem->category_post == 1){
            return view('web.category.blog', $data);
        }
        
        return view('web.category.index', $data);
    }

    public function blog()
    {
        return view('web.category.blog');
    }
}
