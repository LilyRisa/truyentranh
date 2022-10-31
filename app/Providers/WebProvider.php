<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WebProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            ['web.block._sidebar'],
            'App\Http\ViewComposers\Web\SidebarComposer'
        );
        view()->composer(
            ['web.block._layout','web.block._footer','web.block._menu', 'web.block._canvas_menu','web.block._sidebar'],
            'App\Http\ViewComposers\Web\LayoutComposer'
        );
        view()->composer(
            ['web._header', 'web.block._footer', 'web.block._menu', 'web.block._canvas_menu', 'web.block.amp-header'],
            'App\Http\ViewComposers\Web\MenuComposer'
        );
      
    }
}
