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

Route::get('/admin', 'Admin\LoginController@login');
Route::get('/admin/login', 'Admin\LoginController@login')->name('login');
Route::post('/admin/dologin', 'Admin\LoginController@authenticate');
Route::get('/admin/forgot', 'Admin\LoginController@forgot');
Route::post('/admin/forgotten', 'Admin\LoginController@forgotten');
Route::any('otp/{id}', [
    'as' => 'otp',
    'uses' => 'Admin\LoginController@showotp'
 ]);
 Route::post('/admin/resend_otp','Admin\LoginController@resendotp');
 Route::post('/admin/checkOTP', 'Admin\LoginController@checkOTP');
 Route::get('/admin/resetPassword/{id}', 'Admin\LoginController@resetPassword')->name('resetPassword');
 Route::post('/admin/ConfirmPassword', 'Admin\LoginController@ConfirmPassword');
 Route::get('/admin/logout', 'Admin\AdminController@getLogout');
 

 Route::group(['middleware' => ['\App\Http\Middleware\AdminAuth'], 'prefix' => 'admin'], function () {

    Route::get('/dashboard', 'Admin\AdminController@dashboard')->name('dashboard');
    Route::post('/user/change_status','Admin\UserController@change_status');
    Route::get('/user-management', 'Admin\UserController@index');
    Route::post('/user/filter', [
        'uses' => 'Admin\UserController@filter_list',
        'as' => 'admin.user.filter'
    ]);
    Route::get('/user-detail/{id}', 'Admin\UserController@show');

    Route::get('/plate-management', 'Admin\PlateController@index');
    Route::get('/upload_plate','Admin\PlateController@upload_plate');
    Route::get('/plate_detail/{id}', 'Admin\PlateController@plateDetail');
    Route::post('/plate_delete','Admin\PlateController@plate_delete');
    Route::get('/upload_plate_page','Admin\PlateController@upload_plate_page');

    




 Route::get('/sub-admin-management', 'Admin\SubAdminController@index');
 Route::post('/sub-admin/change_status','Admin\SubAdminController@change_status');
 Route::post('sub_admin/submit','Admin\SubAdminController@submit');
 Route::any('edit-subadmin/{id}', 'Admin\SubAdminController@edit_subadmin');
 Route::post('/subadmin/edit_update/{id}','Admin\SubAdminController@edit_update');

 Route::get('/content-management','Admin\ContentController@index');
 Route::get('/edit-content/{id}','Admin\ContentController@content_edit');
 Route::post('/content/update/{id}','Admin\ContentController@update');

 


 Route::get('/query-management','Admin\QueryController@index');
 Route::post('/query/filter', [
    'uses' => 'Admin\QueryController@filter_list',
    'as' => 'admin.query.filter'
]);
Route::post('/query-delete','Admin\QueryController@query_delete');
Route::get('/query-detail/{id}', 'Admin\QueryController@queryDetail');
Route::post('/query/reply', [
    'uses' => 'Admin\QueryController@query_reply',
    'as' => 'admin.query.reply'
]);



});
