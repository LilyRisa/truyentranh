<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use App\Models\Level;
use Illuminate\Support\Facades\URL;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_level_id = Auth::user()->level_id;
        $group = Level::find($user_level_id);
        $permission = json_decode($group->permission, 1);
        #
        $controller = getCurrentController();
        $action = getCurrentAction();
        // dd($controller, $action, $permission);

        if (!in_array($controller, ['home', 'ajax', 'adminimages']) && $action != 'logout') {
            if ($action == 'update') {
                if (!empty(getCurrentParams())) $action = 'edit';
                else $action = 'add';
            }
            if (empty($permission[$controller][$action])) {
                return redirect('/admin/home');
            }
        }

        session_start();
        $_SESSION['user'] = Auth::user()->username;

        return $next($request);
    }
}
