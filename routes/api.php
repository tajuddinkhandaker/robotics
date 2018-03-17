<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api', 'as' => 'goodbots::'], function () {

	Route::apiResource('components', 'ComponentController');

	Route::group([ 'middleware' => [ 'cors', 'client' ] ], function () {

	    Route::get('/iot/test', 'ComponentController@states');
	});
});

Route::group(['prefix' => 'v1', 'middleware' => 'guest:api', 'as' => 'goodbots::'], function () {

	Route::group([ 'prefix' => 'clients', 'middleware' => [ 'cors' ] ], function () {

	    Route::post('/log', 'ComponentController@log')->name('ĺog');
	});
});