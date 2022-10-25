<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post_Category;
use App\Models\Video_Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Post;
use App\Models\Story;
use Illuminate\Support\Facades\DB;
use Response;
use Hash;
use App\Models\Post_tag;
use App\Models\Video_tag;
use App\Models\Story_tag;
use App\Models\Story_category;
use App\Service\GoogleApi;
use Cache;
use Illuminate\Support\Facades\Http;

class AjaxController extends Controller
{
    public function changePassword(Request $request) {
        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');
        $current_password = Auth::user()->password;

        if (Hash::check($old_password, $current_password)) {
            User::find(Auth::user()->id)->update(['password' => bcrypt($new_password)]);
            Auth::user()->update(['password' => bcrypt($new_password)]);
            $response['status'] = 'success';
            $response['message'] = 'Thay đổi mật khẩu thành công!';
        } else {
            $response['status'] = 'fail';
            $response['message'] = 'Mật khẩu cũ không đúng';
        }
        return Response::json($response);
    }

    public function loadTag(Request $request) {
        if($request->has('video_id')){
            $video_id = $request->input('video_id');
            $data['tag_selected'] = [];
            if ($video_id > 0) {
                $listCategory = Video_tag::where(['video_id' => $video_id])->get();
                foreach ($listCategory as $value) {
                    $data['tag_selected'][] = $value->category_id;
                }
            }
            $data['list_tag'] = [];
            $rs = Tag::all();
            foreach ($rs as $value) {
                $data['list_tag'][] = [
                    'value' => $value->id,
                    'text' => $value->title,
                ];
            }
            return Response::json($data);
        }

        $post_id = $request->input('post_id');
        $story_id = $request->input('story_id');
        if(empty($post_id) && !empty($story_id)){
            $data['tag_selected'] = [];
            if ($post_id > 0) {
                $listTag = Story_tag::where(['story_id' => $post_id])->get();
                foreach ($listTag as $value) {
                    $data['tag_selected'][] = $value->tag_id;
                }
            }
            $data['list_tag'] = [];
            $rs = Tag::all();
            foreach ($rs as $value) {
                $data['list_tag'][] = [
                    'value' => $value->id,
                    'text' => $value->title,
                ];
            }
            return Response::json($data);
        }
        $data['tag_selected'] = [];
        if ($post_id > 0) {
            $listTag = Post_tag::where(['post_id' => $post_id])->get();
            foreach ($listTag as $value) {
                $data['tag_selected'][] = $value->tag_id;
            }
        }
        $data['list_tag'] = [];
        $rs = Tag::all();
        foreach ($rs as $value) {
            $data['list_tag'][] = [
                'value' => $value->id,
                'text' => $value->title,
            ];
        }
        return Response::json($data);
    }

    public function loadCategory(Request $request) {
        if($request->has('video_id')){
            $video_id = $request->input('video_id');
            $data['category_selected'] = [];
            if ($video_id > 0) {
                $listCategory = Video_Category::where(['video_id' => $video_id])->get();
                foreach ($listCategory as $value) {
                    $data['category_selected'][] = $value->category_id;
                }
            }
            $data['list_category'] = [];
            $rs = Category::all();
            foreach ($rs as $value) {
                $data['list_category'][] = [
                    'value' => $value->id,
                    'text' => $value->title,
                ];
            }
            return Response::json($data);
        }
        
        $post_id = $request->input('post_id');
        $story_id = $request->input('story_id');
        if(empty($post_id) && !empty($story_id)){
            $data['category_selected'] = [];
            if ($story_id > 0) {
                $listCategory = Story_category::where(['story_id' => $story_id])->orderBy('is_primary', 'DESC')->get();
                foreach ($listCategory as $value) {
                    $data['category_selected'][] = $value->category_id;
                }
            }
            $data['list_category'] = [];
            $rs = Category::all();
            foreach ($rs as $value) {
                $data['list_category'][] = [
                    'value' => $value->id,
                    'text' => $value->title,
                ];
            }
            return Response::json($data);
        }

        $data['category_selected'] = [];
        if ($post_id > 0) {
            $listCategory = Post_Category::where(['post_id' => $post_id])->orderBy('is_primary', 'DESC')->get();
            foreach ($listCategory as $value) {
                $data['category_selected'][] = $value->category_id;
            }
        }
        $data['list_category'] = [];
        $rs = Category::all();
        foreach ($rs as $value) {
            $data['list_category'][] = [
                'value' => $value->id,
                'text' => $value->title,
            ];
        }
        return Response::json($data);
    }

    public function google_index(Request $request){
        $action = $request->input('action');
        $url = $request->input('url');

        $data = GoogleApi::init()->addScope();

        if($action == 'check'){
            $check = $data->check($url);
            $resp = [
                'status' => !empty($check) ? true : false,
                'mess' => !empty($check) ? 'Đã được lập chỉ mục' : 'Chưa được lập chỉ mục'
            ];

        }else if($action == 'update'){

            $check = $data->index($url);
            $resp = [
                'status' => !empty($check) ? true : false,
                'mess' => !empty($check) ? 'Đã yêu cầu lập chỉ mục' : 'Lỗi'
            ];

        }else{
            $check = $data->index($url, 'delete');
            $resp = [
                'status' => !empty($check) ? true : false,
                'mess' => !empty($check) ? 'Đã yêu cầu xóa lập chỉ mục' : 'Lỗi'
            ];
        }

        return \response()->json($resp);
    }

    public function home_feature(Request $request){
        $id = $request->input('id');

        $id_post_old = Post::where('is_feature_home', 1)->first()->id;
        // dd($id_post_old);

        try{
            Post::where('id', $id_post_old)->update(['is_feature_home' => 0]);
            $data = Post::find($id);
            $data->is_feature_home = 1;
            $data->save();
            $cache_post_feature = md5('post_feature-with-category-user-displayed_time-desc');
            if(Cache::has($cache_post_feature)){
                Cache::forget($cache_post_feature);
            }
            return \Response::json(['status' => true, 'mess' => 'Cập nhật thành công bài viết có id:'.$id]);
        }catch(\Exception $e){
            return \Response::json(['status' => false, 'mess' => 'Lỗi hệ thống']);
        }

    }

    public function home_feature_story(Request $request){
        $id = $request->input('id');
        try{
            $data = Story::find($id);
            if($data->is_home == 1){
                $data->is_home = 0;
            }else{
                $data->is_home = 1;
            }
            $data->save();
            $cache_post_feature = md5('story_feature-with-category-user-displayed_time-desc');
            if(Cache::has($cache_post_feature)){
                Cache::forget($cache_post_feature);
            }
            return \response()->json(['status' => true, 'mess' => 'Cập nhật thành công truyện có id:'.$id]);
        }catch(\Exception $e){
            return \response()->json(['status' => false, 'mess' => 'Lỗi hệ thống']);
        }
    }

    public function getTrafficNow(){
        $data = GoogleApi::init()->addScope('analytics')->getRealtimeUser();
        $data_result = [];
        if(!empty($data->rows)){
            foreach($data->rows as $d){
                $data_result[] = [
                    'country' => $d->dimensionValues[0]->value,
                     'count' => $d->metricValues[0]->value,
                ];
            }
        }
        
        return \response()->json($data_result);
    }

    public function getTrafficCount(){
        $user_traffic = GoogleApi::init()->addScope('analytics')->initializeAnalytics()->getFirstProfileId()->getResults();
        $user_traffic = !empty($user_traffic->rows) ? $user_traffic->rows[0][0] : 0;

        return \response()->json([
            'data' => $user_traffic
        ]);
    }

    public function RemoveCacheCloudflare(){
        $id_zone = \Config::get('cloudflare.id_zone');
        $api_key = \Config::get('cloudflare.api_key');
        $email = \Config::get('cloudflare.email');
        $req = Http::acceptJson()->withHeaders([
            'X-Auth-Email' => $email,
            'X-Auth-Key' => $api_key,
            'Content-Type' => 'application/json'
        ])->post('https://api.cloudflare.com/client/v4/zones/'.$id_zone.'/purge_cache', [
            'purge_everything' => true,
        ]);
        
        $data = json_decode($req->body());
        if($data->success) return \response()->json(['status' => true]);
        return \response()->json(['status' => false]);
        
    }
    public function graphqlCloudflareAnalytic(){
        
    }
}
