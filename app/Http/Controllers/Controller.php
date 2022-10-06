<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // dd(url()->current());
        $checkAmp = preg_match('/\/amp\//',url()->current().'/');
        define('IS_AMP', $checkAmp);
        // define('IS_MOBILE', isMobile());
        if (IS_AMP)
            define('TEMPLATE', 'web._amp-layout');
        else
            define('TEMPLATE', 'web._layout');

    }
}
