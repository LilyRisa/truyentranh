<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Request;
use Redirect;
use App\Models\Tag;

class TagController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $limit = 10;
        $count = Tag::count();
        $pagination = (int) ceil($count/$limit);
        #
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        #
        $data['listItem'] = Tag::offset(($page-1)*$limit)->limit($limit)->get();
        $data['pagination'] = $pagination;
        $data['page'] = $page;
        return view('admin.tag.index', $data);
    }

    public function update($id = 0) {
        $data = [];
        if ($id > 0) $data['oneItem'] = $oneItem = Tag::findOrFail($id);
        if (!empty(Request::post())) {
            $post_data = Request::post();
            $post_data['slug'] = toSlug($post_data['title']);
            Tag::updateOrInsert(['id' => $id], $post_data);
            return Redirect::to('/admin/tag');
        }
        return view('admin.tag.update', $data);
    }

    public function delete($id) {
        Tag::destroy($id);
        return back();
    }
}
