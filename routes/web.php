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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::any('/login', "Index\\LoginController@login");
Route::any('/add', "Index\\LoginController@add");
Route::any('/wechat', "Index\\LoginController@wechat");
Route::any('/wechat/index', "Index\\WechatController@index");
Route::any('/do_wechatlogin', "Index\\LoginController@do_wechatlogin");
Route::group(['middleware'=>['Login']],function(){
//Route::domain('index.zhaoshilong.com')->middleware('Login')->group(function () {

        Route::any('/week/add', "Index\\WeekController@add");
//    Route::any('/ll', "Index\\IndexController@ll");

    Route::any('/index', "Index\\LoginController@index");

});
//Route::domain('admin.zhaoshilong.com')->group(function () {
//
//    Route::any('/admin', "Admin\\AdminController@admin");
//    Route::any('/week/update', "Admin\\AdminController@update");
//    Route::any('/update_add', "Admin\\AdminController@update_add");
//
//
//});
////->middleware('Apis')
//Route::domain('Api.zhaoshilong.com')->group(function () {
//
//    Route::any('/login', "Api\\ApiController@login");
//    Route::any('/getadd', "Api\\WechrController@getadd");
//
//});







