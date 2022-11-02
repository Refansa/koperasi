<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    /**
     * Show the signin page.
     */
    function index()
    {
        return inertia('signin');
    }

    /**
     * Processing the signin request.
     */
    function signIn(Request $request)
    {
        $credentials = $request->validate([
            'email'     => ['required', 'email', 'max:255'],
            'password'  => ['required', 'string', 'min:8', 'max:24'],
        ]);

        $remember = $request->get('rememberMe');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin');
            }

            return redirect()->route('home')->with([
                'alert.content' => 'Selamat datang, ' . auth()->user()->name . '!',
                'alert.type'    => 'info',
            ]);
        }

        return back()->withErrors(['email' => 'Email atau password salah!']);
    }
}
