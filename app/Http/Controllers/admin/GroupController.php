<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Request;
use Redirect;
use App\Models\Level;

class GroupController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $data['listItem'] = Level::all();
        return view('admin.group.index', $data);
    }

    public function update($id = 0) {
        $data = [];
        if ($id > 0) {
            $data['oneItem'] = $oneItem = Level::findOrFail($id);
            $data['permission'] = json_decode($oneItem->permission, true);
        }
        if (!empty(Request::post())) {
            $post_data = Request::post();
            $post_data['permission'] = json_encode($post_data['permission']);
            Level::updateOrInsert(['id' => $id], $post_data);
            return Redirect::to('/admin/group');
        }
        $data['listPermission'] = getListPermission();
        return view('admin.group.update', $data);
    }

    public function delete($id) {
        Level::destroy($id);
        return back();
    }
}
