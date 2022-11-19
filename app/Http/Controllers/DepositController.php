<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Saving;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index()
    {
        $users = User::all();
        return inertia('admin.transaction.deposit', [
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'   => ['required', 'numeric'],
            'amount'    => ['required', 'numeric'],
        ]);

        $user   = User::find($data['user_id']);
        $saving = $user->m_saving;

        if (is_null($saving)) {
            $saving = $user->m_saving()->create([
                'deposit_amount'    => 0,
                'loan_amount'       => 0,
            ]);
        }

        $transaction = $user->transactions()->save(
            new Transaction([
                'amount' => $data['amount'],
            ]),
        );

        $transaction->deposit()->save(
            new Deposit([
                'user_id' => $user->id,
            ]),
        );

        $user->m_saving()->update([
            'deposit_amount' => $saving->deposit_amount + $data['amount'],
        ]);

        return redirect()->route('admin.deposit.receipt', $transaction->deposit->id)->with([
            'alert.content' => 'Simpan berhasil',
            'alert.type'    => 'success',
        ]);
    }

    public function receipt(Deposit $deposit)
    {
        $deposit->load('user');
        $deposit->load('transaction');

        return inertia('admin.transaction.deposit.receipt', [
            'deposit' => $deposit,
        ]);
    }

    public function print(Deposit $deposit)
    {
        $pdf = Pdf::loadView('blade.receipt.deposit', ['deposit' => $deposit]);
        return $pdf->stream('receipt.pdf');
    }
}
