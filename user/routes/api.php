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

Route::group(['prefix' => 'v1'],function(){
	// User Registration
	Route::post('register','Api\V1\RegisterController@register');	
	// User Login
	Route::post('login','Api\V1\AuthController@login');	
	
	Route::group(['middleware' => ['jwt.verify']], function() {
		// Login User Details
	    Route::get('me', 'Api\V1\AuthController@me');
	    // User Logout
	    Route::get('logout', 'Api\V1\AuthController@logout');
	    // Token Regenerate
	    Route::get('refresh', 'Api\V1\AuthController@refresh');
	});
});
