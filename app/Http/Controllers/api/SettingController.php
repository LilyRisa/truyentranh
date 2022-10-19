<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\ApiController;
use App\Models\SiteSetting;
use App\Models\Menu;

use Illuminate\Http\Request;
use Redirect;

class SettingController extends ApiController
{

    public function index(Request $request){


        $data = SiteSetting::all();

        return \response()->json($data);
    }

    public function menu(){
        $data = Menu::all();
        return \response()->json($data);
    }

}
