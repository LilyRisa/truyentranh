<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\SiteRedirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Redirect_301
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $uri = $request->getRequestUri();

        /*redirect db*/
        $all = SiteRedirect::getAll();
        $arrOriginalUrl = array_column($all, 'original_url');
        $arrRedirectlUrl = array_column($all, 'target_url');

        $data = array_combine($arrOriginalUrl, $arrRedirectlUrl);
        if (isset($data[$uri])) {
            $url_redirect = url($data[$uri]);
            return Redirect::to($url_redirect, 301);
        }

        if (preg_match('/\/\/+/', $uri)) {
            $uri_redirect = preg_replace('/\/\/+/', '/', $uri);
            return Redirect::to(url($uri_redirect), 301);
        }

        if (substr($uri, -3) == 'amp')
            {
                $uri = str_replace('amp','',$uri);
                return Redirect::to(url($uri), 301);}

        if (substr($uri, -1) == '/' && $uri != '/')
            return Redirect::to(url($uri), 301);

        return $next($request);
    }
}
