<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
use App\Models\Deposit;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function account_index()
    {
        $user = User::find(auth()->user()->id);
        $user->load('m_saving');

        $setting = Setting::first();

        $has_mandatory = Deposit::where('user_id', $user->id)
            ->where('type', 'Wajib')
            ->where('created_at', '>=', now()->startOfMonth())
            ->where('created_at', '<=', now()->startOfMonth()->addMonth())
            ->get()->isEmpty();

        return inertia('account.transaction.deposit', [
            'user'          => $user,
            'setting'       => $setting,
            'has_mandatory' => $has_mandatory,
        ]);
    }

    public function account_payment(Request $request)
    {
        $amount             = $request->get('amount');
        $type               = $request->get('type');
        $midtransServerKey  = env('MIDTRANS_SERVER_KEY');
        $midtransClientKey  = env('MIDTRANS_CLIENT_KEY');

        \Midtrans\Config::$serverKey    = $midtransServerKey;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        \Midtrans\Config::$is3ds        = true;

        $snapParams = [
            'transaction_details' => [
                'order_id'      => 'deposit' . '-' . auth()->user()->id . '-' . $amount . '-' . $type . '-' . rand(),
                'gross_amount'  => $amount,
            ],
            'customer_details' => [
                'first_name'    => auth()->user()->name,
                'email'         => auth()->user()->email,
                'address'       => auth()->user()->address,
                'phone'         => auth()->user()->contact,
            ],
            'item_details' => [
                [
                    'id'        => auth()->user()->id,
                    'quantity'  => 1,
                    'price'     => $amount,
                    'name'      => 'Transaksi Simpan',
                    'brand'     => 'Koperasi Jaya',
                    'category'  => $type,
                ]
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($snapParams);

        return inertia('account.transaction.deposit.payment', [
            'amount'            => $amount,
            'type'              => $type,
            'snapToken'         => $snapToken,
            'midtransClientKey' => $midtransClientKey,
        ]);
    }

    public function account_redirect_payment()
    {
        return redirect()->route('account.deposit.index');
    }

    public function account_receipt(Deposit $deposit)
    {
        if ($deposit->user_id != auth()->user()->id and auth()->user()->role == 'anggota') {
            return abort(403);
        }

        $deposit->load('user');
        $deposit->load('transaction');

        return inertia('account.transaction.deposit.receipt', [
            'deposit' => $deposit,
        ]);
    }

    public function account_print(Deposit $deposit)
    {
        if ($deposit->user_id != auth()->user()->id and auth()->user()->role == 'anggota') {
            return abort(403);
        }

        $pdf = Pdf::loadView('blade.receipt.deposit', ['deposit' => $deposit]);
        return $pdf->stream('receipt.pdf');
    }

    public function account_data()
    {
        $deposits = Deposit::where('user_id', auth()->user()->id)->get();
        $deposits->load('user');
        $deposits->load('transaction');

        return inertia('account.transactions.deposit', [
            'deposits' => $deposits,
        ]);
    }
}
