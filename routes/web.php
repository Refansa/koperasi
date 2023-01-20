<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignOutController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
use App\Models\User;
use Illuminate\Http\Request;
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
    Route::post('/signin', [SignInController::class, 'signin'])->name('signin.post');
});

Route::middleware('auth')->group(function () {
    Route::name('admin.')->middleware('admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('home');

        Route::resource('users', UserController::class)->except(['update']);
        Route::post('users/{user}', [UserController::class, 'update'])->name('users.update');

        Route::get('savings', [UserController::class, 'savings_index'])->name('savings.index');

        Route::get('deposit', [DepositController::class, 'index'])->name('deposit.index');
        Route::post('deposit', [DepositController::class, 'store'])->name('deposit.store');
        Route::get('deposit/receipt/{deposit}', [DepositController::class, 'receipt'])->name('deposit.receipt');
        Route::get('deposit/print/{deposit}', [DepositController::class, 'print'])->name('deposit.print');

        Route::get('withdraw', [WithdrawController::class, 'index'])->name('withdraw.index');
        Route::post('withdraw', [WithdrawController::class, 'store'])->name('withdraw.store');
        Route::get('withdraw/receipt/{withdraw}', [WithdrawController::class, 'receipt'])->name('withdraw.receipt');
        Route::get('withdraw/print/{withdraw}', [WithdrawController::class, 'print'])->name('withdraw.print');

        Route::get('loan', [LoanController::class, 'index'])->name('loan.index');
        Route::post('loan', [LoanController::class, 'store'])->name('loan.store');
        Route::get('loan/receipt/{loan}', [LoanController::class, 'receipt'])->name('loan.receipt');
        Route::get('loan/print/{loan}', [LoanController::class, 'print'])->name('loan.print');

        Route::get('installment', [InstallmentController::class, 'index'])->name('installment.index');
        Route::post('installment', [InstallmentController::class, 'store'])->name('installment.store');
        Route::get('installment/receipt/{installment}', [InstallmentController::class, 'receipt'])->name('installment.receipt');
        Route::get('installment/print/{installment}', [InstallmentController::class, 'print'])->name('installment.print');

        Route::name('transactions.')->prefix('transactions')->group(function () {
            Route::get('deposit', [DepositController::class, 'data'])->name('deposit');
            Route::get('withdraw', [WithdrawController::class, 'data'])->name('withdraw');
            Route::get('loan', [LoanController::class, 'data'])->name('loan');
            Route::get('installment', [InstallmentController::class, 'data'])->name('installment');
        });

        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
    });

    Route::get('/', [RouteController::class, 'home'])->name('home');

    Route::post('/signout', [SignOutController::class, 'signout'])->name('signout');
});

// Development Purpose, used as a placeholder unspecified routes.
Route::any('/stub', fn () => abort(404))->name('stub');
Route::any('/test', function (Request $request) {
    dd($request->all());
})->name('test');
