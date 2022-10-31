<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Request;
use Redirect;
use App\Models\Category;
use App\Models\Post_Category;
use App\Models\Story_category;
use Route;

class CategoryController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $data['category_post'] = $category_post = $_GET['category_post'];
        $listItem = Category::where('category_post', $category_post)->get();
        foreach ($listItem as $key => $item) {
            if($category_post == 1){
                $listItem[$key]->count_post = Post_Category::where('category_id', $item->id)->count();
            }else{
                $listItem[$key]->count_story = Story_category::where('category_id', $item->id)->count();
            }
            
        }
        $data['listItem'] = $listItem;
        return view('admin.category.index', $data);
    }

    public function update($id = 0) {
        $cate_story = Category::getTree(0);
        $cate_post = Category::getTree(0);
        $data['categoryTree'] = array_merge($cate_story, $cate_post);
        if ($id > 0) $data['oneItem'] = $oneItem = Category::findOrFail($id);
        if (!empty(Request::post())) {
            $post_data = Request::post();
            // dd($post_data['parent_id']);
            if($post_data['parent_id'] == 0) unset($post_data['parent_id']);
            Category::updateOrInsert(['id' => $id], $post_data);
            return Redirect::to('/admin/category?category_post='.$post_data['category_post']);
        }
        return view('admin.category.update', $data);
    }

    public function delete($id) {
        Category::destroy($id);
        return back();
    }
}
