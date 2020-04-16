<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'BoardController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/city/get-cities', 'CityController@getCities')->name('city.get-cities');

Route::resource('departures', 'DepartureController');
Route::resource('delays', 'DelayController');

Route::get('trashed-departures', 'DepartureController@trashed')->name('trashed-departures.index');
Route::put('restore-departure/{departure}', 'DepartureController@restore')->name('restore-departures');

Route::resource('passengers', 'PassengerController');
Route::resource('cities', 'CityController');
