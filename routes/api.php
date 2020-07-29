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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

//user
Route::post('login','Api\AuthController@login');
Route::post('register','Api\AuthController@register');
Route::get('logout','Api\AuthController@logout');

//donation
Route::post('donations/create','Api\DonationsController@create')->middleware('jwtAuth');
Route::post('donations/delete','Api\DonationsController@delete')->middleware('jwtAuth');
Route::post('donations/update','Api\DonationsController@update')->middleware('jwtAuth');
Route::get('donations','Api\DonationsController@donations')->middleware('jwtAuth');
Route::get('donations/my_donations','Api\DonationsController@myDonations')->middleware('jwtAuth');

//requests
Route::post('donations/request','Api\RequestsController@request')->middleware('jwtAuth');

