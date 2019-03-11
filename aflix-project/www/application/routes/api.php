<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


Route::group(['prefix' => '/v1'], function()
{

    Route::get('/', 'Api\v1\ApiController@index');
    Route::get('/login', 'Api\v1\UserController@login');
    //Route::post('/login', 'Api\v1\UserController@login');
    //Route::post('userregistration', 'ThemeAuthController@userregistration');
 
    Route::get('/banners', 'Api\v1\ApiController@banners');

    Route::get('videos', 'Api\v1\VideoController@index');
    Route::get('videos/popular', 'Api\v1\VideoController@popular');
    Route::get('videos/recent', 'Api\v1\VideoController@recent');
    Route::post('videos/search', 'Api\v1\VideoController@search');
    Route::get('videos/subscribed', 'Api\v1\VideoController@subscribed');
    Route::get('videos/category/{id}', 'Api\v1\VideoController@categoryVideoList');
    Route::get('video/{id}', 'Api\v1\VideoController@video');
    Route::post('video/suggestions', 'Api\v1\VideoController@suggestions');
    Route::get('video_categories', 'Api\v1\VideoController@video_categories');
    Route::get('video_category/{id}', 'Api\v1\VideoController@video_category');

    Route::get('posts', 'Api\v1\PostController@index');
    Route::get('post/{id}', 'Api\v1\PostController@post');
    Route::get('post_categories', 'Api\v1\PostController@post_categories');
    Route::get('post_category/{id}', 'Api\v1\PostController@post_category');
});


Route::group(array('prefix' => '/v1','middleware' => 'Subscribed'), function()
{

});

