<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignOutController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
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
        Route::resource('divisions', DivisionController::class);

        Route::resource('suppliers', SupplierController::class);

        Route::resource('items/categories', ItemCategoryController::class)
            ->names('items.categories')
            ->parameter('categories', 'itemCategory');
        Route::resource('items', ItemController::class);

        Route::get('deposit', [DepositController::class, 'index'])->name('deposit.index');
        Route::post('deposit', [DepositController::class, 'store'])->name('deposit.store');
        Route::get('deposit/receipt/{deposit}', [DepositController::class, 'receipt'])->name('deposit.receipt');
        Route::get('deposit/receipt/{deposit}/print', [DepositController::class, 'print'])->name('deposit.receipt.print');
        Route::get('withdraw', [WithdrawController::class, 'index'])->name('withdraw.index');
        Route::post('withdraw', [WithdrawController::class, 'store'])->name('withdraw.store');
    });

    Route::get('/', [RouteController::class, 'home'])->name('home');

    Route::post('/signout', [SignOutController::class, 'signOut'])->name('signout');
});

// Development Purpose, used as a placeholder unspecified routes.
Route::any('/stub', fn () => abort(404))->name('stub');
