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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/* Set API Lang */
\App::setlocale(!empty(request()->header('Lang')) ? request()->header('Lang') : 'en');


/*Services Without token*/
Route::get('/home_screen', 'Api\AuthController@home_screen');
Route::post('/login', 'Api\AuthController@login')->name('login');
Route::post('/verification', 'Api\AuthController@verification');
Route::post('resendOTP', 'Api\AuthController@resendOTP');
Route::get('aboutUs', 'Api\AuthController@aboutUs');
Route::get('privacyPolicy', 'Api\AuthController@privacyPolicy');
Route::get('terms_&_conditions', 'Api\AuthController@termsConditions');


Route::group(['middleware' => 'auth:api','namespace' => 'Api'], function(){ 
    Route::get('favourite_list', 'AuthController@favourite_list');
    Route::post('Add_to_favourite', 'AuthController@Add_to_favourite');
    Route::post('unFavourite', 'AuthController@unFavourite');
    Route::post('searchPlate', 'AuthController@searchPlate');
    Route::post('createUserName', 'AuthController@createUserName');
    Route::post('editProfile', 'AuthController@editProfile');
    Route::get('myPlates', 'AuthController@myPlates');
    Route::post('uploadPlate', 'AuthController@uploadPlate');
    Route::get('notification', 'AuthController@notification');
    Route::post('helpSupport', 'AuthController@helpSupport');
    Route::post('filterPlate','AuthController@filterPlate');


    
});

