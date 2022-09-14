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

Route::get('/', function () {
    return view('web.home.index');
});

Route::get('/menu', function () {
    return view('web.menubook.index');
});

Route::get('/book', function () {
    return view('web.menubook.book');
});

Route::get('/category', function () {
    return view('web.category.index');
});