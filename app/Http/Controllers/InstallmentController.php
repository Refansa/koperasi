<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    public function index()
    {
        $loans = Loan::all()->where('status', 'UNPAID');
        $loans->load('user');
        $loans->load('transaction');
        $loans->load('installment_tracker');

        return inertia('admin.transaction.installment', [
            'loans' => $loans,
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
