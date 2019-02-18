<?php

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


Route::group(["middleware"=>"auth"],function(){
    Route::get('/', 'FeedController@index');
    Route::post('/posts','PostController@createNewPost');
    Route::get('/posts','PostController@getAllPosts');
    Route::get('/profile/{user}','UserController@profile');
    Route::get('/users/{user}/posts','UserController@posts');
    Route::post("/posts/{post}/comments","PostController@comment");
});

Auth::routes();
Route::get('/logout','Auth\LoginController@logout');