<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ShortLink;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    public function index() {
        $data = [];
        return view('admin.home.index', $data);
    }

    public function cache_clear(){
        Artisan::call('cache:clear');
        echo 'Đã Xóa thành công!';
        return;
    }

    public function shorturl(Request $request){
        $url = $request->input('url');
        $url_gen = substr(base_convert(md5($url), 16,32), 0, 12);
        $link = ShortLink::where('slug_gen', $url_gen)->first();
        if(!empty($link)){
            return response()->json(['url_new' => $url_gen]);
        }
        $link = new ShortLink();
        $link->slug_original = $url;
        $link->slug_gen = $url_gen;
        $link->save();
        return response()->json(['url_new' => $url_gen]);
    }
}
