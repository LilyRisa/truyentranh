<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\InternalLink;
use App\Models\Match;
use App\Models\User;
use Illuminate\Http\Request;
use App\Service\Upload;
use Carbon\Carbon;
use Redirect;
use App\Models\ImageUpload;
// use App\Models\Category;
// //use App\Models\Post_tag;
// use App\Models\Post_Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class AdminImagesController extends Controller
{

    public function upload(Request $request){
        $image = $request->file('file');
        // dd($image);
        $filename = md5(uniqid().Carbon::now()->timestamp).$image->getClientOriginalName();
        $data = Upload::upload($image, $filename, 60);
        $img = new ImageUpload();
        // dd($data);
        $img->name = $data['data']->data->image->filename;
        $img->data = json_encode(['image' => $data['data']->data->image, 'thumb' => $data['data']->data->thumb]);
        $img->delete_url = $data['data']->data->delete_url;
        $img->save();
        return response()->json(['status' => true, 'data' => $data['data']->data->image->filename]);
    }

}
