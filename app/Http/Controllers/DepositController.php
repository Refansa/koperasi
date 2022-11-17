<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Saving;
use App\Models\Transaction;
use App\Models\User;
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

        return back()->with([
            'alert.content' => 'Simpan berhasil',
            'alert.type'    => 'success',
        ]);
    }
}
