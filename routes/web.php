<?php

use App\Http\Controllers\RouteController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignOutController;
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


Route::middleware('guest')->group(function () {
    Route::get('/signin', [SignInController::class, 'index'])->name('signin');
    Route::post('/signin', [SignInController::class, 'signIn'])->name('signin.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [RouteController::class, 'home'])->name('home');

    Route::post('/signout', [SignOutController::class, 'signOut'])->name('signout');
});
