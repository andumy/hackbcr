<?php

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
    return redirect('/home');
});
Auth::routes();

Route::post('/2fa', 'TwoFactorController@verifyTwoFactor')->middleware('auth');
Route::get('/reset2fa', 'TwoFactorController@resendToken')->name('2fareset')->middleware('auth');

Route::group(['middleware' => ['auth','2fa']], function () {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/2fa', 'TwoFactorController@show')->name('2fa');
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::resource('department','DepartmentController');
	Route::resource('transaction','TransactionController');
	Route::post('transaction/{trans}/sign','TransactionController@sign');
	Route::get('transaction/{trans}/sign','TransactionController@sign_off');
	Route::resource('team','TeamController');
	Route::get('department/remove/{user_id}/{depart_id}','DepartmentController@remove')->name('department.remove');
	Route::get('department/lead/{user_id}/{depart_id}','DepartmentController@lead')->name('department.lead');
	Route::get('team/remove/{user_id}/{team_id}','TeamController@remove')->name('team.remove');
	Route::get('team/lead/{user_id}/{team_id}','TeamController@lead')->name('team.lead');
	Route::resource('feedback','FeedbackController');
});

Route::get('dev','ExempleController@index');