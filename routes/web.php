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

//首页
Route::get('/','PagesController@root')->name('root');

//Auth::routes()
Route::namespace('Auth')->group(function(){
  //登录路由
  Route::get('login','LoginController@showLoginForm')->name('login');
  Route::post('login','LoginController@login');
  Route::post('logout', 'LoginController@logout')->name('logout');

  //注册路由
  Route::get('register','RegisterController@showRegistrationForm')->name('register');
  Route::post('register','RegisterController@register');

  //重置密码
  Route::get('password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
  Route::post('password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');
  Route::get('password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
  Route::post('password/reset','ResetPasswordController@reset');
});

Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}','TopicsController@show')->name('topics.show');


Route::resource('categories','CategoriesController',['only'=>['show']]);

Route::get('getdata','OrderController@getData');

//图片上传

Route::post('upload_image','TopicsController@uploadImage')->name('topics.upload_image');
