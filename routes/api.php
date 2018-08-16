<?php

use Illuminate\Http\Request;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::group(['namespace' => 'Api'], function() {
    //用户相关
    Route::group(['prefix' => 'users', 'namespace' => 'users'], function () {

        //用户注册
        Route::post('/register', 'registerController@register');

        //用户登录
        Route::post('/login', 'registerController@login');
    });
});

