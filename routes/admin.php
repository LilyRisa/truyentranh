<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',function(){
    return redirect('/admin/home');
});
//Login
Route::any('/login','UserController@login')->name('login');

Route::group(['middleware' => ['auth', 'checkPermission']], function () {
    Route::get('/home','HomeController@index');

    /*Home*/
    Route::get('/home','HomeController@index');
    /*Ajax*/
    Route::post('/ajax/changePassword','AjaxController@changePassword');
    Route::post('/ajax/loadTag','AjaxController@loadTag');
    Route::post('/ajax/loadCategory','AjaxController@loadCategory');
    Route::post('/ajax/loadCategoryAuthor','AjaxController@loadCategoryAuthor');

    Route::post('/ajax/google_index','AjaxController@google_index');
    Route::post('/ajax/add_feature_home','AjaxController@home_feature');
    /*Category*/
    Route::get('/category','CategoryController@index');
    Route::any('/category/update','CategoryController@update');
    Route::any('/category/update/{id}','CategoryController@update')->where(['id' => '[0-9]+']);
    Route::any('/category/delete/{id}','CategoryController@delete')->where(['id' => '[0-9]+']);
    /* category author*/
    Route::get('/category/author', 'CategoryAuthorController@index');
    Route::any('/category/author/update','CategoryAuthorController@update');
    Route::any('/category/author/update/{id}','CategoryAuthorController@update')->where(['id' => '[0-9]+']);
    Route::any('/category/author/delete/{id}','CategoryAuthorController@delete')->where(['id' => '[0-9]+']);
    /*User*/
    Route::any('/user','UserController@index');
    Route::any('/user/update','UserController@update');
    Route::any('/user/update/{id}','UserController@update')->where(['id' => '[0-9]+']);
    Route::any('/user/delete/{id}','UserController@delete')->where(['id' => '[0-9]+']);
    Route::any('/user/logout','UserController@logout');
    /*Tag*/
    Route::get('/tag','TagController@index');
    Route::any('/tag/update','TagController@update');
    Route::any('/tag/update/{id}','TagController@update')->where(['id' => '[0-9]+']);
    Route::any('/tag/delete/{id}','TagController@delete')->where(['id' => '[0-9]+']);
    /*Post*/
    Route::get('/post','PostController@index');
    Route::any('/post/update','PostController@update');
    Route::any('/post/update/{id}','PostController@update')->where(['id' => '[0-9]+']);
    Route::any('/post/delete/{id}','PostController@delete')->where(['id' => '[0-9]+']);
    // /*video*/
    // Route::get('/video','VideoController@index')->name('video');
    // Route::any('/video/update','VideoController@update')->name('video.update');
    // Route::any('/video/update/{id}','VideoController@update')->where(['id' => '[0-9]+'])->name('video.updateid');
    // Route::any('/video/delete/{id}','VideoController@delete')->where(['id' => '[0-9]+'])->name('video.deleteid');
    /*Page*/
    Route::get('/page','PageController@index');
    Route::any('/page/update','PageController@update');
    Route::any('/page/update/{id}','PageController@update')->where(['id' => '[0-9]+']);
    Route::any('/page/delete/{id}','PageController@delete')->where(['id' => '[0-9]+']);


    /*Group Permission*/
    Route::get('/group','GroupController@index');
    Route::any('/group/update','GroupController@update');
    Route::any('/group/update/{id}','GroupController@update')->where(['id' => '[0-9]+']);
    Route::any('/group/delete/{id}','GroupController@delete')->where(['id' => '[0-9]+']);

    /*Site setting*/
    Route::any('/site_setting/update','Site_SettingController@update');
    Route::any('/site_setting/daga','Site_SettingController@updateSettingDaGa');
    /*Redirect*/
    Route::get('/redirect','RedirectController@index');
    Route::any('/redirect/update','RedirectController@update');
    Route::any('/redirect/update/{id}','RedirectController@update')->where(['id' => '[0-9]+']);
    Route::any('/redirect/delete/{id}','RedirectController@delete')->where(['id' => '[0-9]+']);
    /*Menu*/
    Route::get('/menu','MenuController@index');
    Route::any('/menu/update','MenuController@update');
    Route::any('/menu/update/{id}','MenuController@update')->where(['id' => '[0-9]+']);
    Route::any('/menu/delete/{id}','MenuController@delete')->where(['id' => '[0-9]+']);
    // /*Banner*/
    // Route::get('/banner','BannerController@index');
    // Route::any('/banner/update','BannerController@update');
    // Route::any('/banner/update/{id}','BannerController@update')->where(['id' => '[0-9]+']);
    // Route::any('/banner/delete/{id}','BannerController@delete')->where(['id' => '[0-9]+']);
    /*short code*/
    Route::get('/shortcode','ShortCodeController@index');
    Route::any('/shortcode/update','ShortCodeController@update');
    Route::any('/shortcode/update/{id}','ShortCodeController@update')->where(['id' => '[0-9]+']);
    Route::any('/shortcode/delete/{id}','ShortCodeController@delete')->where(['id' => '[0-9]+']);

    /*Internal_Link_Handle*/
    Route::get('/internal_link','InternalLinkController@index');
    Route::any('/internal_link/update','InternalLinkController@update');
    Route::any('/internal_link/update/{id}','InternalLinkController@update')->where(['id' => '[0-9]+']);
    Route::any('/internal_link/delete/{id}','InternalLinkController@delete')->where(['id' => '[0-9]+']);

    //upload image
    Route::post('/upload_image','AdminImagesController@upload');

    //Clear Cache facade value:
    Route::get('/clear-cache', 'HomeController@cache_clear');
    Route::post('/ajax-short-url', 'HomeController@shorturl');
    Route::get('/get_user_now', 'AjaxController@getTrafficNow');
    Route::get('/get_user_count', 'AjaxController@getTrafficCount');
    // google index 
    Route::get('/google_index','GoogleIndexController@index');

    // cloudflare
    Route::get('/cloudflare_cache_remove', 'AjaxController@RemoveCacheCloudflare');
});
