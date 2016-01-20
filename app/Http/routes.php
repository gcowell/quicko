<?php

Route::get('/', 'PagesController@index');
Route::get('/home', 'HomeController@index');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

//Journey routes
Route::get('journeys', 'JourneyController@index');
Route::get('journeys/create', 'JourneyController@create');
Route::post('journeys', 'JourneyController@store');
Route::get('journeys/{id}', 'JourneyController@show');

//Parcel routes
Route::get('parcels', 'ParcelsController@index');
Route::get('parcels/create', 'ParcelsController@create');
Route::post('parcels', 'ParcelsController@store');
Route::get('parcels/{id}', 'ParcelsController@show');
Route::get('parcels/{id}/{range}', 'ParcelsController@matchToJourney');

//User routes
Route::get('users/dashboard', 'UserController@index');
Route::get('users/{id}', 'UserController@show');



