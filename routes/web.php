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

Route::any('/tin-tuc/{slug}.html', 'PostController@index')->where(['slug' => '[\s\S]+']);
Route::any('/amp/tin-tuc/{slug}.html', 'PostController@ampIndex')->where(['slug' => '[\s\S]+']);

Route::get('/truyen/{slug}-c{id}', 'StoryController@index')->where(['slug' => '[\s\S]+', 'id' => '[0-9]+']);

Route::get('/img-proxy={url?}', 'ProxyController@img')->where('url', '(.*)');

// rate
Route::post('/post/ajax_rate','PostController@ajax_rate')->name('rating');
Route::post('/story/ajax_rate','StoryController@ajax_rate')->name('rating_story');

/*Category story*/
Route::get('/amp/{slug}-c{id}', 'CategoryController@ampIndex')->where(['slug' => '[\s\S]+', 'id' => '[0-9]+']);
Route::get('/amp/{slug}-c{id}/{page}', 'CategoryController@ampIndex')->where(['slug' => '[\s\S]+', 'id' => '[0-9]+','page' => '[0-9]+']);

Route::get('/{slug}-c{id}', 'CategoryController@index')->where(['slug' => '[\s\S]+', 'id' => '[0-9]+']);
Route::get('/{slug}-c{id}/{page}', 'CategoryController@index')->where(['slug' => '[\s\S]+', 'id' => '[0-9]+','page' => '[0-9]+']);

// search 
Route::get('/tim-kiem-truyen/{search}', 'SearchController@story')->where(['search' => '[\s\S]+']);