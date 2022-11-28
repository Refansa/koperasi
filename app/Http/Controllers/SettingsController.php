<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        return inertia('admin.settings.index', [
            'setting' => $setting,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'minimum_basic_cost'        => ['required', 'numeric', 'min:0'],
            'minimum_mandatory_cost'    => ['required', 'numeric', 'min:0'],
            'maximum_loan_amount'       => ['required', 'numeric', 'min:0'],
            'saving_limit_for_loan'     => ['required', 'numeric', 'min:0'],
        ]);

        Setting::first()->update($data);

        return back()->with([
            'alert.content' => 'Pengaturan koperasi berhasil diubah',
            'alert.type'    => 'success',
        ]);
    }
}
