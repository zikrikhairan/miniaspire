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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
    Route::post('add_loans', 'API\UserController@add_loans');
    Route::post('repayment', 'API\UserController@repayment');
});

Route::post('loan_duration', 'API\UserController@loan_duration');
Route::post('loan_repayment_frequency', 'API\UserController@loan_repayment_frequency');
Route::post('loan_interest_rate', 'API\UserController@loan_interest_rate');
Route::post('loan_arrangement_fee', 'API\UserController@loan_arrangement_fee');