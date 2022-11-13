<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        $user->load('division');

        return inertia('admin.users.index', ['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisions = Division::all();

        return inertia('admin.users.create', ['divisions' => $divisions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string'],
            'email'         => ['required', 'email', 'unique:users', 'max:255'],
            'password'      => ['required', 'string', 'min:8', 'max:24'],
            'role'          => ['required', 'string'],
            'division_id'   => ['required', 'numeric'],
            'address'       => ['required', 'string'],
            'contact'       => ['required', 'string'],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')->with([
            'alert.content' => 'Pengguna berhasil dibuat',
            'alert.type'    => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $divisions = Division::all();
        $user->load('division');

        return inertia('admin.users.edit', [
            'user'      => $user,
            'divisions' => $divisions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name'      => ['required', 'string'],
            'role'      => ['required', 'string'],
            'division'  => ['required', 'numeric'],
            'address'   => ['required', 'string'],
            'contact'   => ['required', 'string'],
        ];

        if ($request->email != $user->email) {
            $rules['email'] = ['required', 'email', 'unique:users', 'max:255'];
        }

        if ($request->password) {
            $rules['password']  = ['required', 'string', 'min:8', 'max:24'];
        }

        $data = $request->validate($rules);

        $division = Division::find($data['division']);
        $data['division_id'] = $division->id;
        unset($data['division']);

        if ($request->password) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with([
            'alert.content' => 'Pengguna berhasil diubah',
            'alert.type'    => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return back()->with([
            'alert.content' => 'Pengguna berhasil dihapus',
            'alert.type' => 'success',
        ]);
    }
}
