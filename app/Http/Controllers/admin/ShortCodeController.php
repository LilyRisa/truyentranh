<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Request;
use Redirect;
use App\Models\ShortCode;
use Route;

class ShortCodeController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $listItem = ShortCode::all();
        $data['listItem'] = $listItem;
        return view('admin.shortcode.index', $data);
    }

    public function update($id = 0) {
        $data = [];
        if ($id > 0) $data['oneItem'] = $oneItem = ShortCode::findOrFail($id);
        if (!empty(Request::post())) {
            ShortCode::updateOrInsert(['id' => $id], Request::post());
            return Redirect::to('/admin/shortcode');
        }
        return view('admin.shortcode.update', $data);
    }

    public function delete($id) {
        ShortCode::destroy($id);
        return back();
    }
}
