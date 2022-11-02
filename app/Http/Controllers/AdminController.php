<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index()
    {
        $user       = User::all()->count();
        $supplier   = Supplier::all()->count();
        $item       = Item::all()->count();

        return inertia('admin.index', [
            'user'      => $user,
            'supplier'  => $supplier,
            'item'      => $item,
        ]);
    }
}
