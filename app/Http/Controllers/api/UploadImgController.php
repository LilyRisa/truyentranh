<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Redirect;

class UploadImgController extends ApiController
{

    public function index(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'filename' => 'required|string'
            ]);
    
            if ($request->has('image')) {
                $image = $request->file('image');
                $filename = $request->input('filename');
                $folder_return = '/upload/admin/story/'.date("Y").'/'.((int) date('m')).'/';
                $folder_move = base_path().'/public'.$folder_return;
    

                if(!file_exists($folder_move)) mkdir($folder_move, 0777, true);

                $filePath_return = $folder_return . $filename;
                $filePath_move = $folder_move . $filename;
                try{
                    $image->move($folder_move, $filename);
                    return \response()->json([
                        'status' => true,
                        'path' => $filePath_return
                    ]);
                }catch(\Exception $e){
                    return \response()->json([
                        'status' => false,
                        'messeges' => $e
                    ]);
                }
                
            }else{
                return \response()->json([
                    'status' => false,
                    'messeges' => 'khong ton tai file'
                ]);
            }
    }

    private function folder_exist($folder)
    {
        // Get canonicalized absolute pathname
        $path = realpath($folder);

        // If it exist, check if it's a directory
        if($path !== false AND is_dir($path))
        {
            // Return canonicalized absolute pathname
            return $path;
        }

        // Path/folder does not exist
        return false;
}

}
