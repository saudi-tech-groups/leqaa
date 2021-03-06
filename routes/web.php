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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')
    ->name('home');

Route::group(['prefix' => 'auth'], function () {
    Auth::routes();

    Route::get('login/github', 'Auth\LoginController@redirectToGithub');
    Route::get('login/github/callback', 'Auth\LoginController@handleGithubCallback');

    Route::get('verify/{user_id}/{token}', 'Auth\RegisterController@verify')
        ->name('email_verify');
});
