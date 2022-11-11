<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignOutController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
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
    Route::name('admin.')->middleware('admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('home');

        Route::resource('users', UserController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('items', ItemController::class);
        Route::resource('divisions', DivisionController::class);
    });

    Route::get('/', [RouteController::class, 'home'])->name('home');

    Route::post('/signout', [SignOutController::class, 'signOut'])->name('signout');
});
