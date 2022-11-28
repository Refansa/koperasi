<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
use App\Models\Deposit;
use App\Models\Saving;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index()
    {
        $users = User::all();
        $setting = Setting::first();
        return inertia('admin.transaction.deposit', [
            'users'     => $users,
            'setting'   => $setting,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'   => ['required', 'numeric'],
            'amount'    => ['required', 'numeric'],
            'type'      => ['required', 'string'],
        ]);

        $user           = User::find($data['user_id']);
        $cooperative    = Cooperative::first();

        $saving = $user->m_saving;

        $transaction = $user->transactions()->save(
            new Transaction([
                'amount' => $data['amount'],
            ]),
        );

        $transaction->deposit()->save(
            new Deposit([
                'user_id'   => $user->id,
                'type'      => $data['type'],
            ]),
        );

        switch ($data['type']) {
            case 'Pokok':
                $user->m_saving()->update([
                    'basic_amount'  => $saving->basic_amount + $data['amount'],
                ]);
                break;
            case 'Wajib':
                $user->m_saving()->update([
                    'mandatory_amount'  => $saving->mandatory_amount + $data['amount'],
                ]);
                break;
            case 'Sukarela':
                $user->m_saving()->update([
                    'voluntary_amount'  => $saving->voluntary_amount + $data['amount'],
                ]);
                break;
        }

        $cooperative->update([
            'total_deposit_amount' => $cooperative->total_deposit_amount + $data['amount'],
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

    public function data()
    {
        $deposits = Deposit::all();
        $deposits->load('user');
        $deposits->load('transaction');

        return inertia('admin.transactions.deposit', [
            'deposits' => $deposits,
        ]);
    }
}
