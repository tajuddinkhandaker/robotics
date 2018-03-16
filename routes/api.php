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


	Route::resource('components', 'ComponentController');

    Route::get('/iot/test2', function (Request $remoteRequest) {
        
        return response()->json([ 'lights' => [ 0, 1 ] ], 200, [
        	'Access-Control-Allow-Origin' => '*'
        ]);
        
    });
    Route::get('/iot/test', 'ComponentController@states')->middleware('cors');
});