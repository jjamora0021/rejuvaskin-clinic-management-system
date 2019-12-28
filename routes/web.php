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

// Login and Logout
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/logout', function() {
	Session::flush();
	Auth::logout();

	return redirect('/login');
});

// Authentication Routes
Auth::routes();

Route::middleware('auth')->group(function() {

	// DASHBOARD
	Route::get('dashboard','DashboardController@index')->name('dashboard');

	// STAFFS
	Route::get('view-staff','StaffsController@showUser')->name('view-staff');
	Route::get('get-user-details','StaffsController@getUserDetails');
	Route::get('get-users','StaffsController@getAllUsers');

	Route::get('create-staff-profile','StaffsController@showCreateUser')->name('create-staff-profile');
	Route::post('create-user','StaffsController@createUser');
	Route::get('update-user','StaffsController@updateUser');
	Route::get('delete-user','StaffsController@deleteUser');


	// TIME KEEPING
	Route::get('time-keeping','TimeKeepingController@showTimeKeeping');
	Route::get('save-time-in','TimeKeepingController@saveTimeIn');
	Route::get('save-time-out','TimeKeepingController@saveTimeOut');

	Route::get('get-latest-time-keeping','TimeKeepingController@getLatestTimeKeeping');

	// SCHEDULES
	Route::get('schedules','SchedulesController@showSchedules');
	Route::post('save-schedule','SchedulesController@saveSchedule')->name('save-schedule');

	Route::get('get-staff-schedule','SchedulesController@getStaffSchedule')->name('get-staff-schedule');
});

