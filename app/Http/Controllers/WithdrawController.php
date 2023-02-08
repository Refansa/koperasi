<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
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
            'type'      => ['required', 'string'],
        ]);

        $user           = User::find($data['user_id']);
        $cooperative    = Cooperative::first();

        switch ($data['type']) {
            case 'Pokok':
                if ($user->m_saving->basic_amount >= $data['amount']) {
                    $transaction = $user->transactions()->save(
                        new Transaction([
                            'amount' => $data['amount'],
                        ]),
                    );

                    $transaction->withdraw()->save(
                        new Withdraw([
                            'user_id'   => $user->id,
                            'type'      => $data['type'],
                        ]),
                    );

                    $user->m_saving()->update([
                        'basic_amount'  => $user->m_saving->basic_amount - $data['amount'],
                    ]);

                    $cooperative->update([
                        'total_deposit_amount' => $cooperative->total_deposit_amount - $data['amount'],
                    ]);

                    return redirect()->route('admin.withdraw.receipt', $transaction->withdraw->id)->with([
                        'alert.content' => 'Tarik berhasil',
                        'alert.type'    => 'success',
                    ]);
                }
                break;
            case 'Wajib':
                if ($user->m_saving->mandatory_amount >= $data['amount']) {
                    $transaction = $user->transactions()->save(
                        new Transaction([
                            'amount' => $data['amount'],
                        ]),
                    );

                    $transaction->withdraw()->save(
                        new Withdraw([
                            'user_id'   => $user->id,
                            'type'      => $data['type'],
                        ]),
                    );

                    $user->m_saving()->update([
                        'mandatory_amount'  => $user->m_saving->mandatory_amount - $data['amount'],
                    ]);

                    $cooperative->update([
                        'total_deposit_amount' => $cooperative->total_deposit_amount - $data['amount'],
                    ]);

                    return redirect()->route('admin.withdraw.receipt', $transaction->withdraw->id)->with([
                        'alert.content' => 'Tarik berhasil',
                        'alert.type'    => 'success',
                    ]);
                }
                break;
            case 'Sukarela':
                if ($user->m_saving->voluntary_amount >= $data['amount']) {
                    $transaction = $user->transactions()->save(
                        new Transaction([
                            'amount' => $data['amount'],
                        ]),
                    );

                    $transaction->withdraw()->save(
                        new Withdraw([
                            'user_id'   => $user->id,
                            'type'      => $data['type'],
                        ]),
                    );

                    $user->m_saving()->update([
                        'voluntary_amount'  => $user->m_saving->voluntary_amount - $data['amount'],
                    ]);

                    $cooperative->update([
                        'total_deposit_amount' => $cooperative->total_deposit_amount - $data['amount'],
                    ]);

                    return redirect()->route('admin.withdraw.receipt', $transaction->withdraw->id)->with([
                        'alert.content' => 'Tarik berhasil',
                        'alert.type'    => 'success',
                    ]);
                }
                break;
            case 'Semua':
                $basic_amount = $user->m_saving->basic_amount;
                $mandatory_amount = $user->m_saving->mandatory_amount;
                $voluntary_amount = $user->m_saving->voluntary_amount;
                $all_amount = $basic_amount + $mandatory_amount + $voluntary_amount;

                if ($all_amount >= $data['amount']) {
                    $transaction = $user->transactions()->save(
                        new Transaction([
                            'amount' => $data['amount'],
                        ]),
                    );

                    $transaction->withdraw()->save(
                        new Withdraw([
                            'user_id'   => $user->id,
                            'type'      => $data['type'],
                        ]),
                    );

                    $user->m_saving()->update([
                        'basic_amount'      => 0,
                        'mandatory_amount'  => 0,
                        'voluntary_amount'  => 0,
                    ]);

                    $cooperative->update([
                        'total_deposit_amount' => $cooperative->total_deposit_amount - $data['amount'],
                    ]);

                    return redirect()->route('admin.withdraw.receipt', $transaction->withdraw->id)->with([
                        'alert.content' => 'Tarik berhasil',
                        'alert.type'    => 'success',
                    ]);
                }
                break;
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

    public function account_data()
    {
        $withdraws = Withdraw::where('user_id', auth()->user()->id)->get();
        $withdraws->load('user');
        $withdraws->load('transaction');

        return inertia('account.transactions.withdraw', [
            'withdraws' => $withdraws,
        ]);
    }

    public function account_receipt(Withdraw $withdraw)
    {
        if ($withdraw->user_id != auth()->user()->id and auth()->user()->role == 'anggota') {
            return abort(403);
        }

        $withdraw->load('user');
        $withdraw->load('transaction');

        return inertia('account.transaction.withdraw.receipt', [
            'withdraw' => $withdraw,
        ]);
    }

    public function account_print(Withdraw $withdraw)
    {
        if ($withdraw->user_id != auth()->user()->id and auth()->user()->role == 'anggota') {
            return abort(403);
        }

        $pdf = Pdf::loadView('blade.receipt.withdraw', ['withdraw' => $withdraw]);
        return $pdf->stream('receipt.pdf');
    }
}
