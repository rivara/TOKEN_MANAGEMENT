<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

Auth::routes();

    Route::get('/', function () {return view('auth/login');});
    Route::get('home', 'HomeController@index')->name('index');

// gestion usuarios
    Route::get ('auth/', 'HomeController@gouser')->name('goUser');
    Route::get ('auth/register', 'HomeController@goregister')->name('goRegister');
    Route::post('auth/register', 'HomeController@create')->name('create');
    Route::get ('auth/delete', 'HomeController@delete')->name('delete');
    Route::get ('auth/update', 'HomeController@goupdate')->name('goUpdate');
    Route::post('auth/update', 'HomeController@update')->name('update');

// gestion tokens
    Route::get ('token/', 'TokenController@gotokens')->name('goToken');
    Route::get ('token/register', 'TokenController@gotokensegister')->name('goTokensRegister');
    Route::post('token/register', 'TokenController@create')->name('createToken');
    Route::get ('token/delete', 'TokenController@delete')->name('deleteToken');
    Route::get ('token/update', 'TokenController@goupdate')->name('goUpdateToken');
    Route::post('token/update', 'TokenController@update')->name('updateToken');


