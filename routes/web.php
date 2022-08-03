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

Route::resource('/home', ForumController::class, ['except' => ['show', 'edit', 'update', 'destroy']]);
Route::get('/home/{forums:slug}', [ForumController::class, 'show'])->name('home.show');
Route::get('/home/{forums:slug}/edit', [ForumController::class, 'edit'])->name('home.edit');
Route::patch('/home/{forums:slug}/edit', [ForumController::class, 'update'])->name('home.update');
Route::delete('/home/{forums:slug}', [ForumController::class, 'destroy'])->name('home.destroy');
Route::get('/home/tags/{tags:slug}', [TagController::class, 'show'])->name('tags.show');
Route::post('/home/{forum:id}/answer', [ForumController::class, 'answerStore'])->name('home.answer.store');

// Route::controller(ForumController::class)->group(function () {
//     Route::get('/forum', 'index')->name('home');
//     Route::get('/forum/create', 'create')->name('forum.create');
//     Route::post('/forum/store', 'store')->name('forum.store');
//     Route::get('/forum/{forum:slug}', 'show')->name('forum.show');
//     Route::get('/forum/{forum}/edit', 'edit')->name('forum.edit');
//     Route::put('/forum/{forum}/update', 'update')->name('forum.update');
//     Route::delete('/forum/{forum}/delete', 'delete')->name('forum.delete');
// });

//socialite
Route::get('/auth/{driver}', [LoginSocialiteController::class, 'google'])->name('sign-in-socialite');
Route::get('/auth/{driver}/callback', [LoginSocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');
