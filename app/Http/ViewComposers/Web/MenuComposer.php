<?php

namespace App\Http\ViewComposers\Web;

use Illuminate\View\View;
use App\Models\Menu;

class MenuComposer
{
    public function compose(View $view)
    {
        $data['menu_pc'] = Menu::where('id', 1)->first();
        $data['menu_pc'] = !empty($data['menu_pc']) ? json_decode($data['menu_pc']->data) : null;
        
        $data['menu_footer'] = Menu::where('id', 4)->first(); 
        $data['menu_footer'] = !empty($data['menu_footer']) ? json_decode($data['menu_footer']->data) : null;
    
        $data['menu_mobile'] = Menu::where('id', 2)->first();
        $data['menu_mobile'] = !empty($data['menu_mobile']) ? json_decode($data['menu_mobile']->data) : null;
        $view->with($data);
    }
}
