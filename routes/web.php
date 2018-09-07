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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'LoginController@index');
Route::post('/loginMe', 'LoginController@loginMe');

Route::get('/logout', 'UserController@logout');
Route::get('/dashboard', 'UserController@index')->middleware('checkLogin');
Route::get('/users', 'UserController@users')->middleware('checkLogin');
Route::get('/users/create', 'UserController@create')->middleware('checkLogin');
Route::post('/users/checkEmailExists', 'UserController@checkEmailExists')->middleware('checkLogin');
Route::post('/users/createUser', 'UserController@createUser')->middleware('checkLogin');