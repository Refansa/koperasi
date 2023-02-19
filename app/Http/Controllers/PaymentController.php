<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
use App\Models\Deposit;
use App\Models\Installment;
use App\Models\Loan;
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

                    $transaction_type = $data[0];

                    switch ($transaction_type) {
                        case 'deposit':
                            $user_id    = $data[1];
                            $amount     = $data[2];
                            $type       = $data[3];

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

                        case 'installment':
                            $loan_id        = $data[1];
                            $amount         = $data[2];
                            $installment_of = $data[3];
                            $note           = $data[4];

                            if ($note == 'NULL') {
                                $note = '';
                            }

                            $cooperative            = Cooperative::first();
                            $loan                   = Loan::find($loan_id);
                            $user                   = $loan->user;
                            $saving                 = $user->m_saving;
                            $installment_tracker    = $loan->installment_tracker;

                            $transaction = $user->transactions()->save(
                                new Transaction([
                                    'amount' => $amount
                                ]),
                            );

                            $transaction->installment()->save(
                                new Installment([
                                    'user_id'                   => $user->id,
                                    'loan_id'                   => $loan->id,
                                    'installment_tracker_id'    => $installment_tracker->id,
                                    'installment_of'            => $installment_of,
                                    'installment_left'          => $installment_tracker->installment_needed - $installment_of,
                                    'note'                      => $note,
                                ])
                            );

                            if ($installment_of == $installment_tracker->installment_needed) {
                                $loan->update([
                                    'status' => 'PAID',
                                ]);
                            }

                            $installment_tracker->update([
                                'installment_of' =>
                                $installment_of == $installment_tracker->installment_needed
                                    ? $installment_of
                                    : $installment_of + 1,
                            ]);

                            $saving->update([
                                'loan_amount' => $saving->loan_amount - ($loan->transaction->amount / $loan->loan_period),
                            ]);

                            $cooperative->update([
                                'total_loan_amount'     => $cooperative->total_loan_amount - ($loan->transaction->amount / $loan->loan_period),
                                'total_deposit_amount'  => $cooperative->total_deposit_amount + ($amount - ($loan->transaction->amount / $loan->loan_period)),
                            ]);

                            return redirect()->route('account.installment.receipt', $transaction->installment->id)->with([
                                'alert.content' => 'Transaksi Selesai',
                                'alert.type'    => 'success',
                            ]);
                    }
                default:
                    return redirect()->route('account.home')->with([
                        'alert.content' => 'Transaksi Belum Selesai',
                        'alert.type'    => 'warning',
                    ]);
            }
        }
    }

    public function unfinish(Request $request)
    {
        return redirect()->route('home');
    }

    public function error(Request $request)
    {
        return redirect()->route('home');
    }
}
