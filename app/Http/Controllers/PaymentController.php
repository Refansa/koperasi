<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function finish(Request $request)
    {
        if ($request->has('transaction_status')) {
            $transaction_status = $request->transaction_status;

            switch ($transaction_status) {
                case 'settlement':
                case 'capture':
                    $order_id = $request->order_id;

                    $data = explode('-', $order_id);

                    $user_id    = $data[0];
                    $amount     = $data[1];
                    $type       = $data[2];

                    $user           = User::find($user_id);
                    $cooperative    = Cooperative::first();

                    $saving = $user->m_saving;

                    $transaction = $user->transactions()->save(
                        new Transaction([
                            'amount' => $amount,
                        ]),
                    );

                    $transaction->deposit()->save(
                        new Deposit([
                            'user_id'   => $user->id,
                            'type'      => $type,
                        ]),
                    );

                    switch ($type) {
                        case 'Pokok':
                            $user->m_saving()->update([
                                'basic_amount'  => $saving->basic_amount + $amount,
                            ]);
                            break;
                        case 'Wajib':
                            $user->m_saving()->update([
                                'mandatory_amount'  => $saving->mandatory_amount + $amount,
                            ]);
                            break;
                        case 'Sukarela':
                            $user->m_saving()->update([
                                'voluntary_amount'  => $saving->voluntary_amount + $amount,
                            ]);
                            break;
                    }

                    $cooperative->update([
                        'total_deposit_amount' => $cooperative->total_deposit_amount + $amount,
                    ]);

                    return redirect()->route('account.deposit.receipt', $transaction->deposit->id)->with([
                        'alert.content' => 'Transaksi Selesai',
                        'alert.type'    => 'success',
                    ]);
                default:
                    return redirect()->route('account.deposit.index')->with([
                        'alert.content' => 'Transaksi Belum Selesai',
                        'alert.type'    => 'warning',
                    ]);
            }
        }
    }

    public function unfinish(Request $request)
    {
        return dd($request->all());
    }

    public function error(Request $request)
    {
        return dd($request->all());
    }
}
