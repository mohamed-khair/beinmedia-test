<?php

use Illuminate\Support\Facades\Route;

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
    return view('index');
});

Route::apiResource("/experts", "ExpertController");

Route::get('/timezone', 'TimezoneController@getCurrentUserTimezone');
Route::get('/timezones', 'TimezoneController@getAllTimezones');

