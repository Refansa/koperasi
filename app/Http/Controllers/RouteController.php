<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Show the home page.
     */
    public function home()
    {
        return inertia('home');
    }
}
