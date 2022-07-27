<?php

use App\Http\Controllers\Auth\LoginSocialiteController;
use App\Http\Controllers\ForumController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::resource('/home', ForumController::class);

//socialite
Route::get('/auth/{driver}', [LoginSocialiteController::class, 'google'])->name('sign-in-socialite');
Route::get('/auth/{driver}/callback', [LoginSocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');
