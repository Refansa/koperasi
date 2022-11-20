<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignOutController extends Controller
{
    /**
     * Processing the Sign Out request.
     */
    function signout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('signin')->with([
            'alert.content' => 'Keluar berhasil',
            'alert.type' => 'success',
        ]);
    }
}
