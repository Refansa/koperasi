<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdraw;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function index()
    {
        $users = User::all();
        $users->load('m_saving');

        return inertia('admin.transaction.withdraw', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'   => ['required', 'numeric'],
            'amount'    => ['required', 'numeric'],
        ]);

        $user = User::find($data['user_id']);

        if ($user->m_saving->deposit_amount >= $data['amount']) {
            $transaction = $user->transactions()->save(
                new Transaction([
                    'amount' => $data['amount'],
                ]),
            );

            $transaction->withdraw()->save(
                new Withdraw([
                    'user_id' => $user->id,
                ]),
            );

            $user->m_saving()->update([
                'deposit_amount' => $user->m_saving->deposit_amount - $data['amount'],
            ]);

            return redirect()->route('admin.withdraw.receipt', $transaction->withdraw->id)->with([
                'alert.content' => 'Tarik berhasil',
                'alert.type'    => 'success',
            ]);
        }

        return back()->with([
            'alert.content' => 'Saldo tidak mencukupi!',
            'alert.type'    => 'error',
        ]);
    }

    public function receipt(Withdraw $withdraw)
    {
        $withdraw->load('user');
        $withdraw->load('transaction');

        return inertia('admin.transaction.withdraw.receipt', [
            'withdraw' => $withdraw,
        ]);
    }

    public function print(Withdraw $withdraw)
    {
        $pdf = Pdf::loadView('blade.receipt.withdraw', ['withdraw' => $withdraw]);
        return $pdf->stream('receipt.pdf');
    }

    public function data()
    {
        $withdraws = Withdraw::all();
        $withdraws->load('user');
        $withdraws->load('transaction');

        return inertia('admin.transactions.withdraw', [
            'withdraws' => $withdraws,
        ]);
    }
}
