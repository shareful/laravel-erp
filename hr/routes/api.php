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
	Route::group(['middleware' => ['api.verify']], function() {
		// Submit a Leave Application
		Route::post('leave/apply','Api\V1\Leave\SubmitApplicationController@submit');	
		// Leave Application Approve
		Route::put('leave_application/approve/{application_id}','Api\V1\Leave\SubmitApplicationController@approve');
		// Leave Application deny
		Route::put('leave_application/deny/{application_id}','Api\V1\Leave\SubmitApplicationController@deny');

		// Get All Leave Applications
	    Route::get('leave_applications/list', 'Api\V1\Leave\ApplicationsController@list');
	    // A Leave application details
	    Route::get('leave_application/show/{application_id}', 'Api\V1\Leave\ApplicationsController@show');
	    // Get Leave Applications list applied by a user
	    Route::get('leave_applications/list/{user_id}', 'Api\V1\Leave\ApplicationsController@listByUser');
	    // Leave Applications list for auth/logged in user
	    Route::get('leave_applications/my/list', 'Api\V1\Leave\ApplicationsController@listByAuthUser');

	    // Leave already uses by an user
	    // Example: /leave/uses/1?from_date=2018-11-01&to_date=2018-11-05
	    Route::get('leave/uses/{user_id}', 'Api\V1\Leave\UsesController@listByUser');

	    // Leave uses by auth/logged in user
	    // Example: /leave/my/uses?from_date=2018-11-01&to_date=2018-11-05
	    Route::get('leave/my/uses', 'Api\V1\Leave\UsesController@listByAuthUser');
	});
});
