<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Models\Level;
use Illuminate\Support\Facades\Auth;

class SidebarComposer
{
    public function compose(View $view)
    {
        $user_group_id = Auth::user()->level_id;
        $group = Level::find($user_group_id);
        $data['permission'] = json_decode($group->permission, 1);
        $view->with($data);
    }
}
