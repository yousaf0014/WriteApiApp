<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('register', 'API\UserController@register');
Route::post('registerAppSumo', 'API\UserController@registerAppSumo');
Route::post('socailRegister', 'API\UserController@socailRegister');
Route::post('login', 'API\UserController@login');
Route::post('paymentNotification','API\UserController@payment');

Route::post('resetPassword', 'API\PasswordResetController@create');
Route::Post('findUser', 'API\PasswordResetController@find');
Route::Post('passwordRest','API\UserController@sendPasswordRestEmail');
Route::Post('updatePassword','API\UserController@updatePassword');
Route::get('getBasePath','API\UserController@apiBasePath');



Route::middleware('auth:api')->group( function () {
	Route::post('newartical/{project}/{artical}','API\UserDataController@newartical');
	Route::get('details', 'API\UserController@details');
	Route::get('bio/{user}','API\UserController@bio');
	Route::get('userData','API\UserController@userData');
	Route::post('verify', 'API\UserController@verify');
    Route::post('verifyAppSumo', 'API\UserController@verifyAppSumo');
	Route::post('changePassword','API\UserController@changePassword');
	Route::post('uploadUserImage','API\UserController@uploadUserImage');

	Route::get('projects', 'API\UserDataController@getProjects');
	Route::get('project/{project}', 'API\UserDataController@getProject');
	Route::post('saveproject', 'API\UserDataController@saveProject');
	Route::post('updateproject/{project}', 'API\UserDataController@updateProject');
	Route::delete('deleteproject/{project}', 'API\UserDataController@deleteProject');
	Route::post('deleteproject/{project}', 'API\UserDataController@deleteProject');

	Route::get('keywords/{project}', 'API\UserDataController@getkeywords');
	Route::get('getKeyword/{keyword}', 'API\UserDataController@getKeyword');
	Route::post('saveKeyword/{project}', 'API\UserDataController@saveKeywords');
	Route::post('updateKeyword/{project}/{keyword}', 'API\UserDataController@updateKeyword');
	Route::delete('deleteKeyword/{project}/{keyword}', 'API\UserDataController@deleteKeyword');
	Route::post('deleteKeyword/{project}/{keyword}', 'API\UserDataController@deleteKeyword');

	Route::get('categories/{project}', 'API\UserDataController@getCategories');
	Route::get('getCategory/{category}', 'API\UserDataController@getCategory');
	Route::post('saveCategory/{project}', 'API\UserDataController@savecategories');
	Route::post('updateCategory/{project}/{category}', 'API\UserDataController@updateCategory');
	Route::delete('deleteCategory/{project}/{category}', 'API\UserDataController@deleteCategory');
	Route::post('deleteCategory/{project}/{category}', 'API\UserDataController@deleteCategory');


	Route::get('articals/{project}', 'API\UserDataController@getArticals');
	Route::get('getArtical/{artical}', 'API\UserDataController@getArtical');
	Route::post('saveArtical/{project}', 'API\UserDataController@saveArtical');
	Route::post('articalKeywords/{artical}', 'API\UserDataController@articalKeywords');
	Route::post('articalCategories/{artical}', 'API\UserDataController@articalCategories');
	Route::post('updateArtical/{project}/{artical}', 'API\UserDataController@updateArtical');
	Route::delete('deleteArtical/{project}/{artical}', 'API\UserDataController@deleteArtical');
	Route::post('deleteArtical/{project}/{artical}', 'API\UserDataController@deleteArtical');

	Route::post('uploadProjectPic/{project}','API\UserDataController@projectFile');
	Route::get('apiFilePath','API\UserDataController@apiFilePath');
	Route::post('savedownloads','API\UserDataController@savedownloads');
	Route::get('downloads','API\UserDataController@userdownloads');
	Route::get('lastestCategories','API\UserDataController@lastestCategories');
	Route::get('lastArtical','API\UserDataController@getCurrentArtical');

	Route::delete('deletenotification/{notification}', 'API\UserDataController@deleteNotification');
	Route::post('deletenotification/{notification}', 'API\UserDataController@deleteNotification');
	Route::get('getNotifications', 'API\UserDataController@getNotifications');
	Route::get('getUsage', 'API\UserDataController@getUsage');
	Route::get('getUsageLog', 'API\UserDataController@getUsageLog');
	Route::post('updateUsage', 'API\UserDataController@updateUsage');
	Route::post('aiUsage','API\UserDataController@aiUsage');

	//Route::get('getpayments','API\UserDataController@getpayments');

	Route::Post('saveNewArtical/{project}','API\UserDataController@saveNewArtical');
	
});
//Route::middleware('auth:api')->get('/user', function (Request $request) {
  //  return $request->user();
//});
