<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index()
    {
        $user               = User::all()->count();
        $cooperative        = Cooperative::first();
        $today_transaction  = Transaction::where('created_at', '>=', Carbon::today())
            ->where('created_at', '<=', Carbon::tomorrow())
            ->get();

        $today_transaction->load('user');
        $today_transaction->load('deposit');
        $today_transaction->load('withdraw');
        $today_transaction->load('loan');
        $today_transaction->load('installment');

        return inertia('admin.index', [
            'user'              => $user,
            'cooperative'       => $cooperative,
            'today_transaction' => $today_transaction,
        ]);
    }
}
