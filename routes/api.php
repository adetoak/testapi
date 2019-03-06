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

Route::post('/register', 'AuthController@register');

Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

Route::get('/countries', 'CountryController@index')->name('countries.index');

Route::post('/countries', 'CountryController@create')->name('countries.create');

Route::get('/countries/{country}', 'CountryController@show')->name('countries.show');

Route::put('/countries/{country}', 'CountryController@update')->name('countries.update');

Route::delete('/countries/{country}', 'CountryController@destroy')->name('countries.destroy');

Route::get('/users/activities', 'LogController@index')->name('activities.index');