<?php

namespace App\Http\ViewComposers\Web;

use App\Models\SiteSetting;
use Illuminate\View\View;
use Cache;

class LayoutComposer
{
    public function compose(View $view)
    {
        if(Cache::has('site_settings_all')){
            $site_settings = Cache::get('site_settings_all');
        }else{
            $site_settings = SiteSetting::all();
            Cache::set('site_settings_all', $site_settings, now()->addHours(24));
        }
        $data['site_settings'] = $site_settings;
        $view->with($data);
    }
}
