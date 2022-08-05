<?php

use App\Http\Controllers\Auth\LoginSocialiteController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\TagController;
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

//Forum and Answer
Route::controller(ForumController::class)->group(function () {
    Route::middleware('auth')->group(function () {
        Route::prefix('home')->group(function () {
            Route::get('/create', 'create')->name('home.create');
            Route::post('/create', 'store')->name('home.store');
            Route::get('/{forums:slug}/edit', 'edit')->name('home.edit');
            Route::patch('/{forums:slug}/edit', 'update')->name('home.update');
            Route::delete('/{forums:slug}', 'destroy')->name('home.destroy');

            Route::post('/home/{forum:id}/answer', 'answerStore')->name('home.answer.store');
        });
    });
    Route::prefix('home')->group(function () {
        Route::get('/', 'index')->name('home.index');
        Route::get('/{forums:slug}', 'show')->name('home.show');
    });
});
Route::controller(TagController::class)->group(function () {
    Route::get('/tag/{tags:slug}', 'show')->name('tags.show');
});

//socialite
Route::get('/auth/{driver}', [LoginSocialiteController::class, 'google'])->name('sign-in-socialite');
Route::get('/auth/{driver}/callback', [LoginSocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');
