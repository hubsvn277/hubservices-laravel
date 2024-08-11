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

if(config('app.app_install') == true) {

Route::get('/', 'WebsiteController@getLandingPage')->name('home');

Auth::routes(['verify' => true]);

} else {


Route::namespace('Install')->group(function () {

    Route::get('/', function() {

        return redirect('/installation');

    });

    Route::get('install/database', 'InstallController@database');
Route::post('install/process_install', 'InstallController@process_install');
Route::get('install/create_user', 'InstallController@create_user');
Route::post('install/store_user', 'InstallController@store_user');
Route::get('install/system_settings', 'InstallController@system_settings');
Route::post('install/finish', 'InstallController@final_touch');

});

}


