<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignOutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
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

Route::get('/', [RouteController::class, 'home'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/signin', [SignInController::class, 'index'])->name('signin');
    Route::post('/signin', [SignInController::class, 'signin'])->name('signin.post');
});

Route::middleware('auth')->group(function () {
    Route::name('account.')->prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('home');
        Route::get('settings', [AccountController::class, 'settings_index'])->name('settings.index');
        Route::post('settings', [AccountController::class, 'settings_update'])->name('settings.update');

        Route::name('deposit.')->prefix('deposit')->group(function () {
            Route::get('/', [DepositController::class, 'account_index'])->name('index');
            Route::post('/', [DepositController::class, 'account_store'])->name('store');
            Route::get('payment', [DepositController::class, 'account_redirect_payment'])->name('redirect');
            Route::post('payment', [DepositController::class, 'account_payment'])->name('payment');
            Route::get('receipt/{deposit}', [DepositController::class, 'account_receipt'])->name('receipt');
            Route::get('print/{deposit}', [DepositController::class, 'account_print'])->name('print');
        });

        Route::name('payment.')->prefix('payment')->group(function () {
            Route::any('/finish', [PaymentController::class, 'finish'])->name('finish');
            Route::any('/unfinish', [PaymentController::class, 'unfinish'])->name('unfinish');
            Route::any('/error', [PaymentController::class, 'error'])->name('error');
        });

        Route::name('transactions.')->prefix('transactions')->group(function () {
            Route::get('deposit', [DepositController::class, 'account_data'])->name('deposit');
            Route::get('withdraw', [WithdrawController::class, 'account_data'])->name('withdraw');
            Route::get('loan', [LoanController::class, 'account_data'])->name('loan');
            Route::get('installment', [InstallmentController::class, 'account_data'])->name('installment');
        });

        Route::name('withdraw.')->prefix('withdraw')->group(function () {
            Route::get('receipt/{withdraw}', [WithdrawController::class, 'account_receipt'])->name('receipt');
            Route::get('print/{withdraw}', [WithdrawController::class, 'account_print'])->name('print');
        });

        Route::name('loan.')->prefix('loan')->group(function () {
            Route::get('receipt/{loan}', [LoanController::class, 'account_receipt'])->name('receipt');
            Route::get('print/{loan}', [LoanController::class, 'account_print'])->name('print');
        });

        Route::name('installment.')->prefix('installment')->group(function () {
            Route::get('/', [InstallmentController::class, 'account_index'])->name('index');
            Route::post('/', [InstallmentController::class, 'account_store'])->name('store');
            Route::get('receipt/{installment}', [InstallmentController::class, 'account_receipt'])->name('receipt');
            Route::get('print/{installment}', [InstallmentController::class, 'account_print'])->name('print');
        });
    });

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

    Route::post('/signout', [SignOutController::class, 'signout'])->name('signout');
});

// Listener Endpoints
Route::post('/notification/handling', [NotificationController::class, 'handle'])->name('notification.handling');

// Development Purpose, used as a placeholder unspecified routes.
Route::any('/stub', fn () => abort(404))->name('stub');
Route::any('/test', function (Request $request) {
    dd($request->all());
})->name('test');
