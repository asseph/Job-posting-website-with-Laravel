<?php

use Illuminate\Support\Facades\Route;
use App\Models\Listing;

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

//Route::get('/', [ListingController::class, 'index']);

Route::get('/', 'App\Http\Controllers\ListingController@index');





//create
Route::get('/listings/create', 'App\Http\Controllers\ListingController@create')->middleware('auth');


//post job

Route::post('/listings', 'App\Http\Controllers\ListingController@store')->middleware('auth');

//edit form

Route::get('/listings/{listing}/edit', 'App\Http\Controllers\ListingController@edit')->middleware('auth');


//update listing

Route::put('/listings/{listing}', 'App\Http\Controllers\ListingController@update')->middleware('auth');

//delete

Route::delete('/listings/{listing}', 'App\Http\Controllers\ListingController@destroy')->middleware('auth');

//manage listing

Route::get('/listing/manage', 'App\Http\Controllers\ListingController@manage')->middleware('auth');



//Route::get('/listings/{listing}',[ListingController::class, 'show']);

Route::get('/listings/{listing}', 'App\Http\Controllers\ListingController@show');

// register form show

Route::get('/register', 'App\Http\Controllers\UserController@create')->middleware('guest');

//create new user

Route::post('/users', 'App\Http\Controllers\UserController@store');

//logout user

Route::post('/logout', 'App\Http\Controllers\UserController@logout')->middleware('auth');

//login form show

Route::get('/login', 'App\Http\Controllers\UserController@login')->name('login')->middleware('guest');

//login user

Route::post('users/authenticate', 'App\Http\Controllers\UserController@authenticate');





