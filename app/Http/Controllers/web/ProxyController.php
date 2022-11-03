<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{   
    public function img($url)
    {
        // dd($url);
        if(strpos($url, 'https') == false){
            $url = 'https:'.$url;
        }

        if(!filter_var($url, FILTER_VALIDATE_URL)){
            return response('')->header('Content-type','image/png');
        }
        
        $response = Http::withHeaders([
            'Referer' => 'https://www.nettruyenin.com/',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36'
        ])->get($url);

        return response($response->body())->header('Content-type','image/png');

    }
}
