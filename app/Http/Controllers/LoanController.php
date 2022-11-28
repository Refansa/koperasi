<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $users      = User::all();
        $setting    = Setting::first();

        return inertia('admin.transaction.loan', [
            'users'     => $users,
            'setting'   => $setting,
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

        dd($data);
    }
}
