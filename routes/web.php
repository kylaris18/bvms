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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'UserController@index');
Route::get('/login', 'UserController@loginView')->name('login');
Route::post('/login', 'UserController@login');
Route::get('/clear', function(){
	session()->flush();
	return redirect('/');
});
Route::get('/violations/list', 'DashboardController@index');
Route::get('/violations/add', 'DashboardController@add');
Route::post('/violations/addViolation', 'DashboardController@addViolation');
Route::get('/violations/archive', 'DashboardController@archive');
Route::post('/violations/escalate', 'DashboardController@escalateViolation');
Route::post('/violations/resolve', 'DashboardController@resolveViolation');
Route::get('/users/add', 'UserController@addUser');
Route::post('/users/addUser', 'UserController@addNewUser');
Route::get('/users/suspend', 'UserController@suspendUserView');
Route::post('/users/suspendUser', 'UserController@suspendUser');
Route::post('/violations/modify', 'DashboardController@modifyViolation');
Route::get('/report/generate/{violatorId}', 'DashboardController@generateReport');
Route::get('/info', 'UserController@brgyInfo');
Route::post('/info/modify', 'UserController@modifyBrgyInfo');
Route::get('/users/update', 'UserController@updateUser');
Route::post('/users/modify', 'UserController@modifyUser');