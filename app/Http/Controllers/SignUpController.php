<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    public function signup(Request $request)
    {
        $data = $request->validate([
            'name'              => ['required', 'string'],
            'age'               => ['required', 'numeric'],
            'gender'            => ['required', 'string'],
            'occupation'        => ['required', 'string'],
            'address'           => ['required', 'string'],
            'contact'           => ['required', 'string'],
            'email'             => ['required', 'email', 'unique:users', 'max:255'],
            'password'          => ['required', 'string', 'min:8', 'max:24'],
            'reenteredPassword' => ['required', 'string', 'min:8', 'max:24'],
        ]);

        if ($data['password'] != $data['reenteredPassword']) {
            return redirect()->route('signin')->with([
                'alert.content' => 'Password yang diulangi tidak sama!',
                'alert.type'    => 'error',
            ]);
        }

        $data['password']   = Hash::make($data['password']);

        if ($request->picture) {
            $data['picture'] = $request->picture[0]['file']->store('img/profile');
            $data['picture'] = '/storage/' . $data['picture'];
        } else {
            $data['picture'] = '/images/default-profile.jpg';
        }

        User::create($data)->m_saving()->create([
            'basic_amount'      => 0,
            'mandatory_amount'  => 0,
            'voluntary_amount'  => 0,
            'loan_amount'       => 0,
        ]);

        return redirect()->route('signin')->with([
            'alert.content' => 'Pengguna berhasil dibuat, silahkan login',
            'alert.type'    => 'success'
        ]);
    }
}
