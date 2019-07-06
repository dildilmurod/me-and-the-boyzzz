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

Route::post('/physical-register', 'StudentAuthController@register');
Route::post('/physical-login', 'StudentAuthController@login');

Route::post('/legal-register', 'TeacherAuthController@register');
Route::post('/legal-login', 'TeacherAuthController@login');

Route::post('/staff-register', 'StaffAuthController@register');
Route::post('/staff-login', 'StaffAuthController@login');

Route::apiResource('task', 'TaskAPIController');
Route::post('task/{task}', 'TaskAPIController@update');
Route::get('my-tasks', 'TaskAPIController@my_tasks');
Route::get('download-route/{task}', 'TaskAPIController@download_route');

Route::apiResource('solution', 'SolutionAPIController');
Route::post('solution/{solution}', 'SolutionAPIController@update');
Route::get('my-solutions', 'SolutionAPIController@my_solutions');
Route::get('change-status/{solution}', 'SolutionAPIController@change_status');


Route::apiResource('comment', 'CommentAPIController');
Route::post('comment/{comment}', 'CommentAPIController@update');
























Route::resource('tasks', 'TaskAPIController');

Route::resource('solutions', 'SolutionAPIController');

Route::resource('comments', 'CommentAPIController');