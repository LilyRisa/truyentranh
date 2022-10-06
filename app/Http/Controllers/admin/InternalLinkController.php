<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\InternalLink;
use Request;
use Redirect;
use Illuminate\Support\Facades\DB;

class InternalLinkController extends Controller
{
    public function index()
    {
        $data['setting'] = InternalLink::getSetting();
        $listItem = InternalLink::getInterlink();
        $data['listItem'] = $listItem;
        return view('admin.internal_link_handle.index',$data);
    }
    public function update($id = 0) {
        $data = [];
        if ($id > 0) $data['oneItem'] = InternalLink::findOrFail($id);

        if (!empty(Request::post())) {

            // dd($post_data);
            $keyword_multi = json_decode(Request::post()['keyword'], 1);

            $keyword_multi = array_map(function($item){
                $check = DB::table('internal_link_id')->where('slug', toSlug($item['value']))->first();
                if(empty($check)){
                    return $item['value'];
                }
            },$keyword_multi);

            $keyword_multi = array_filter($keyword_multi);

            $keyword = $keyword_multi;
            $keyword_multi = implode(',', $keyword_multi);
            // dd($keyword, $post_data);
            if($id == 0){
                $inter = new InternalLink();
                $inter->title = Request::post()['title'];
                $inter->is_status = Request::post()['is_status'];
                $inter->keyword = $keyword_multi;
                $inter->href = Request::post()['href'];
                $inter->is_tab = Request::post()['is_tab'];
                $inter->is_tag = Request::post()['is_tag'];
                $inter->created_at = now();
                $inter->updated_at = now();
                $id_result = $inter->save();
                $id_result = $inter->id;

                foreach($keyword as $k){
    
                    DB::table('internal_link_id')->insert([
                        'id_internal_link' => $id_result,
                        'keyword' => $k,
                        'slug' => toSlug($k)
                    ]);
                    
                }
            }else{
                DB::table('internal_link_id')->where('id_internal_link', $id)->delete();

                InternalLink::updateOrInsert(['id' => $id], [
                    'title' => Request::post()['title'],
                    'is_status' => Request::post()['is_status'],
                    'keyword' => $keyword_multi,
                    'href' => Request::post()['href'],
                    'is_tab' => Request::post()['is_tab'],
                    'is_tag' => Request::post()['is_tag'],
                    'updated_at' => now(),
                ]);

                foreach($keyword as $k){
  
                    DB::table('internal_link_id')->insert([
                        'id_internal_link' => $id,
                        'keyword' => $k,
                        'slug' => toSlug($k)
                    ]);
                    
                }
            }
            
            return Redirect::to('/admin/internal_link');
        }
        return view('admin.internal_link_handle.update',$data);
    }



    public function delete($id) {
        InternalLink::destroy($id);
        return back();
    }
}
