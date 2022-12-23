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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' =>['auth','web']],function(){
	Route::get('/plans','PlanController@index');
	Route::get('/plans/refresh','PlanController@refresh');
	Route::get('/plans/{plan}/edit','PlanController@edit');
	Route::post('/plans/update/{plan}','PlanController@update');

	Route::get('/deleteUser/{user}','HomeController@lock');
	Route::get('/restore','HomeController@restoreuser');
	Route::get('users','HomeController@userList');
});