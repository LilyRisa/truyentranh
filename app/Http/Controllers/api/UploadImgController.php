<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UploadImgController extends ApiController
{

    public function index(Request $request){
        if(!$request->header('token')) return \response()->json([
            'status' => false,
            'messenges' => 'token invalid'
        ]); 
        $check = DB::table('token_api')->where('token', $request->header('token'))->first();
        if(!$check) return \response()->json([
            'status' => false,
            'messenges' => 'token invalid'
        ]); 

        
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

    public function url(Request $request){
        if(!$request->header('token')) return \response()->json([
            'status' => false,
            'messenges' => 'token invalid'
        ]); 
        $check = DB::table('token_api')->where('token', $request->header('token'))->first();
        if(!$check) return \response()->json([
            'status' => false,
            'messenges' => 'token invalid'
        ]); 

        
        $request->validate([
            'image' => 'required|string',
            'filename' => 'required|string'
            ]);

            $response = Http::withHeaders([
                'Referer' => 'https://www.nettruyenme.com/',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36'
            ])->get($request->input('image'));

    
            $image = $response->body();
            $filename = $request->input('filename');
            $folder_return = '/upload/admin/story/'.date("Y").'/'.((int) date('m')).'/';
            $folder_move = base_path().'/public'.$folder_return;


            if(!file_exists($folder_move)) mkdir($folder_move, 0777, true);

            $filePath_return = $folder_return . $filename;
            $filePath_move = $folder_move . $filename;
            try{
                file_put_contents($filePath_move, $image);
                return \response()->json([
                    'status' => true,
                    'path' => $filePath_return
                ]);
            }catch(\Exception $e){
                return \response()->json([
                    'status' => false,
                    'messeges' => json_encode($e)
                ]);
            }

    }
}


