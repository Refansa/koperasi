<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
use App\Models\Installment;
use App\Models\Loan;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    public function index()
    {
        $loans = Loan::where('status', 'UNPAID')->get();
        $loans->load('user');
        $loans->load('transaction');
        $loans->load('installment_tracker');

        return inertia('admin.transaction.installment', [
            'loans' => $loans,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'loan_id'           => ['required', 'numeric'],
            'amount'            => ['required', 'numeric', 'min:0'],
            'installment_of'    => ['required', 'numeric'],
            'note'              => [],
        ]);

        $cooperative            = Cooperative::first();
        $loan                   = Loan::find($data['loan_id']);
        $user                   = $loan->user;
        $saving                 = $user->m_saving;
        $installment_tracker    = $loan->installment_tracker;

        $transaction = $user->transactions()->save(
            new Transaction([
                'amount' => $data['amount']
            ]),
        );

        $transaction->installment()->save(
            new Installment([
                'user_id'                   => $user->id,
                'loan_id'                   => $loan->id,
                'installment_tracker_id'    => $installment_tracker->id,
                'installment_of'            => $data['installment_of'],
                'installment_left'          => $installment_tracker->installment_needed - $data['installment_of'],
                'note'                      => $data['note'],
            ])
        );

        if ($data['installment_of'] == $installment_tracker->installment_needed) {
            $loan->update([
                'status' => 'PAID',
            ]);
        }

        $installment_tracker->update([
            'installment_of' =>
            $data['installment_of'] == $installment_tracker->installment_needed
                ? $data['installment_of']
                : $data['installment_of'] + 1,
        ]);

        $saving->update([
            'loan_amount' => $saving->loan_amount - ($loan->transaction->amount / $loan->loan_period),
        ]);

        $cooperative->update([
            'total_loan_amount'     => $cooperative->total_loan_amount - ($loan->transaction->amount / $loan->loan_period),
            'total_deposit_amount'  => $cooperative->total_deposit_amount + ($data['amount'] - ($loan->transaction->amount / $loan->loan_period)),
        ]);

        return redirect()->route('admin.installment.receipt', $transaction->installment->id)->with([
            'alert.content' => 'Pembayaran angsuran berhasil',
            'alert.type'    => 'success',
        ]);
    }

    public function receipt(Installment $installment)
    {
        $installment->load('user');
        $installment->load('loan');
        $installment->load('transaction');
        $installment->load('installment_tracker');

        return inertia('admin.transaction.installment.receipt', [
            'installment' => $installment,
        ]);
    }

    public function print(Installment $installment)
    {
        $pdf = Pdf::loadView('blade.receipt.installment', ['installment' => $installment]);
        return $pdf->stream('receipt.pdf');
    }

    public function data()
    {
        $installments = Installment::all();
        $installments->load('user');
        $installments->load('loan');
        $installments->load('transaction');

        return inertia('admin.transactions.installment', [
            'installments' => $installments,
        ]);
    }

    public function account_receipt(Installment $installment)
    {
        if ($installment->user_id != auth()->user()->id and auth()->user()->role == 'anggota') {
            return abort(403);
        }

        $installment->load('user');
        $installment->load('loan');
        $installment->load('transaction');
        $installment->load('installment_tracker');

        return inertia('account.transaction.installment.receipt', [
            'installment' => $installment,
        ]);
    }

    public function account_print(Installment $installment)
    {
        if ($installment->user_id != auth()->user()->id and auth()->user()->role == 'anggota') {
            return abort(403);
        }

        $pdf = Pdf::loadView('blade.receipt.installment', ['installment' => $installment]);
        return $pdf->stream('receipt.pdf');
    }

    public function account_data()
    {
        $installments = Installment::where('user_id', auth()->user()->id)->get();
        $installments->load('user');
        $installments->load('loan');
        $installments->load('transaction');

        return inertia('account.transactions.installment', [
            'installments' => $installments,
        ]);
    }
}
