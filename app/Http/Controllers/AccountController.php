<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    function index()
    {
        return inertia('account.index');
    }
}
