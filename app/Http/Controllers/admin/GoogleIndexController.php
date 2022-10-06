<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;



class GoogleIndexController extends Controller
{
    
    public function index(){
        return view('admin.google_index.index');
    }
}
