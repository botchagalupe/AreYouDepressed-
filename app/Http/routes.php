<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'DepressionController@areTheyDepressed');


Route::get('/admin', ['as' => 'admin', 'uses' => 'DepressionController@adminForm']);
Route::post('/admin/post', ['as' => 'handleAdmin', 'uses' => 'DepressionController@handleAdmin']);
Route::get('/password', ['as' => 'password', 'uses' => 'DepressionController@setPassword']);
Route::get('/answer/{choice}', ['as' => 'answer', 'uses' => 'DepressionController@handleEmail']);