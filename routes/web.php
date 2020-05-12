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

Route::view('/', 'index');

Route::get("/experts", "ExpertController@index");
Route::get("/experts/{expert}", "ExpertController@show");

Route::get('/timezone', 'TimezoneController@getCurrentUserTimezone');
Route::get('/timezones', 'TimezoneController@getAllTimezones');

Route::get("/appointments/slots", "AppointmentController@slots");
Route::post("appointments/store", "AppointmentController@store");
