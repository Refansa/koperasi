<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
use App\Models\InstallmentTracker;
use App\Models\Loan;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $users          = User::all();
        $setting        = Setting::first();
        $cooperative    = Cooperative::first();

        return inertia('admin.transaction.loan', [
            'users'         => $users,
            'setting'       => $setting,
            'cooperative'   => $cooperative,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'       => ['required', 'numeric'],
            'amount'        => ['required', 'numeric', 'min:0'],
            'loan_period'   => ['required', 'numeric'],
            'interest'      => ['required', 'numeric'],
            'note'          => [],
        ]);

        $setting        = Setting::first();
        $cooperative    = Cooperative::first();

        if ($data['amount'] <= $setting->maximum_loan_amount) {
            if ($cooperative->total_deposit_amount >= $setting->saving_limit_for_loan) {
                $user   = User::find($data['user_id']);
                $saving = $user->m_saving;

                $isUserHasUnpaidLoan = $user->loans()->where('status', 'UNPAID')->count();

                if ($isUserHasUnpaidLoan > 0) {
                    return back()->with([
                        'alert.content' => 'Pengguna ini masih belum melunasi pinjaman sebelumnya',
                        'alert.type'    => 'error',
                    ]);
                }

                $transaction = $user->transactions()->save(
                    new Transaction([
                        'amount' => $data['amount'],
                    ]),
                );

                $loan = $transaction->loan()->save(
                    new Loan([
                        'user_id'       => $user->id,
                        'loan_period'   => $data['loan_period'],
                        'interest'      => $data['interest'],
                        'note'          => $data['note'],
                        'status'        => 'UNPAID',
                    ]),
                );

                $loan->installment_tracker()->save(
                    new InstallmentTracker([
                        'user_id'               => $user->id,
                        'installment_of'        => 1,
                        'installment_needed'    => $data['loan_period'],
                    ]),
                );

                $user->m_saving()->update([
                    'loan_amount' => $saving->loan_amount + $data['amount'],
                ]);

                $cooperative->update([
                    'total_loan_amount' => $cooperative->total_loan_amount + $data['amount'],
                ]);

                return redirect()->route('admin.loan.receipt', $transaction->loan->id)->with([
                    'alert.content' => 'Peminjaman berhasil',
                    'alert.type'    => 'success',
                ]);
            }

            return back()->with([
                'alert.content' => 'Peminjaman dinonaktifkan karena tabungan koperasi dibawah limit peminjaman',
                'alert.type'    => 'error',
            ]);
        }

        return back()->with([
            'alert.content' => 'Maksimal jumlah peminjaman adalah Rp. ' . $setting->maximum_loan_amount,
            'alert.type'    => 'error',
        ]);
    }

    public function receipt(Loan $loan)
    {
        $loan->load('user');
        $loan->load('transaction');

        return inertia('admin.transaction.loan.receipt', [
            'loan' => $loan,
        ]);
    }

    public function print(Loan $loan)
    {
        $pdf = Pdf::loadView('blade.receipt.loan', ['loan' => $loan]);
        return $pdf->stream('receipt.pdf');
    }

    public function data()
    {
        $loans = Loan::all();
        $loans->load('user');
        $loans->load('transaction');
        $loans->load('installment_tracker');

        return inertia('admin.transactions.loan', [
            'loans' => $loans,
        ]);
    }

    public function account_receipt(Loan $loan)
    {
        if ($loan->user_id != auth()->user()->id and auth()->user()->role == 'anggota') {
            return abort(403);
        }

        $loan->load('user');
        $loan->load('transaction');

        return inertia('account.transaction.loan.receipt', [
            'loan' => $loan,
        ]);
    }

    public function account_print(Loan $loan)
    {
        if ($loan->user_id != auth()->user()->id and auth()->user()->role == 'anggota') {
            return abort(403);
        }

        $pdf = Pdf::loadView('blade.receipt.loan', ['loan' => $loan]);
        return $pdf->stream('receipt.pdf');
    }

    public function account_data()
    {
        $loans = Loan::where('user_id', auth()->user()->id)->get();
        $loans->load('user');
        $loans->load('transaction');
        $loans->load('installment_tracker');

        return inertia('account.transactions.loan', [
            'loans' => $loans,
        ]);
    }
}
