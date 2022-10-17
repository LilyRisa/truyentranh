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
Route::any('/', 'HomeController@index');

Route::any('/book', 'MenuBookController@index');

Route::any('/reading', 'ReadingController@index');

Route::any('/cate', 'CategoryController@index');
Route::any('/blog', 'CategoryController@blog');

Route::any('/post', 'PostController@index');

Route::get('/truyen/{slug}-c{id}', 'StoryController@index')->where(['slug' => '[\s\S]+', 'id' => '[0-9]+']);

Route::get('/img-proxy={url?}', 'ProxyController@img')->where('url', '(.*)');
