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

Route::get('/', 'homeController@home');
Route::get('/location','homeController@location');

Route::get('/test','AjaxController@test');

Route::post("allpropertiesList",'AjaxController@allpropertiesList');

Route::get("getTotalPages",'AjaxController@getTotalPages');

// Ajax Responses

Route::post('getzipdata', 'AjaxController@getzipResponse');
Route::post('getPropertyResponse','AjaxController@getPropertyResponse');