<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    function index()
    {
        $saving = auth()->user()->m_saving;

        return inertia('account.index', [
            'saving' => $saving,
        ]);
    }

    function settings_index()
    {
        $user = auth()->user();

        return inertia('account.settings.index', [
            'user' => $user,
        ]);
    }

    public function settings_update(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $rules = [
            'name'          => ['required', 'string'],
            'age'           => ['required', 'numeric'],
            'gender'        => ['required', 'string'],
            'occupation'    => ['required', 'string'],
            'address'       => ['required', 'string'],
            'contact'       => ['required', 'string'],
            'role'          => ['required', 'string'],
            'picture'       => [],
        ];

        if ($request->email != $user->email) {
            $rules['email'] = ['required', 'email', 'unique:users', 'max:255'];
        }

        if ($request->password) {
            $rules['password']  = ['required', 'string', 'min:8', 'max:24'];
        }

        $data = $request->validate($rules);

        if ($request->password) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($request->picture[0]['file'])) {
            Storage::delete(str_replace('/storage/', '', $request->oldPicture));
            $data['picture'] = $request->picture[0]['file']->store('img/profile');
            $data['picture'] = '/storage/' . $data['picture'];
        } else if (!isset($request->picture[0])) {
            $data['picture'] = '/images/default-profile.jpg';
        } else {
            $data['picture'] = $request->oldPicture;
        }

        $user->update($data);

        return redirect()->route('account.settings.index')->with([
            'alert.content' => 'Pengguna berhasil diubah',
            'alert.type'    => 'success',
        ]);
    }
}
