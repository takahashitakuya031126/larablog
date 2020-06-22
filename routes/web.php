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

Route::prefix('admin')->group(function() {
    Route::get('form/{article_id?}', 'AdminBlogController@form')->name('admin_form');
    Route::post('post', 'AdminBlogController@post')->name('admin_post');
    Route::post('delete', 'AdminBlogController@delete')->name('admin_delete');
    Route::get('list', 'AdminBlogController@list')->name('admin_list');
});

Route::get('/', 'FrontBlogController@index')->name('front_index');