<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/story','StoryController@index');
Route::get('/story/{id}','StoryController@getone')->where(['id' => '[0-9]+']);

Route::get('/chapter/{story_id}','StoryController@chapter')->where(['id' => '[0-9]+']);

Route::get('/category', 'CategoryController@index');
Route::get('/category/{id}', 'CategoryController@getone')->where(['id' => '[0-9]+']);
Route::get('/category/{id}/{type}', 'CategoryController@gettype')->where(['type' => '[a-zA-Z]+', 'id' => '[0-9]+']);

Route::get('/settings', 'SettingController@index');
Route::get('/menu', 'SettingController@menu');
