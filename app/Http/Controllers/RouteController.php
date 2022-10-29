<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Show the home page.
     */
    function home()
    {
        return inertia('home');
    }
}
