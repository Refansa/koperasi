<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Division::all();

        return inertia('admin.divisions.index', [
            'divisions' => $divisions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('admin.divisions.create');
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
            'position' => ['required', 'string', 'unique:divisions'],
        ]);

        Division::create($data);

        return redirect()->route('admin.divisions.index')->with([
            'alert.content' => 'Bagian berhasil dibuat',
            'alert.type'    => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show(Division $division)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        return inertia('admin.divisions.edit', [
            'division' => $division,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Division $division)
    {
        $data = $request->validate([
            'position' => ['required', 'string', 'unique:divisions'],
        ]);

        $division->update($data);

        return redirect()->route('admin.divisions.index')->with([
            'alert.content' => 'Bagian berhasil diubah',
            'alert.type'    => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division)
    {
        try {
            Division::destroy($division->id);

            return back()->with([
                'alert.content' => 'Bagian berhasil dihapus',
                'alert.type'    => 'success',
            ]);
        } catch (\Illuminate\Database\QueryException) {
            return back()->with([
                'alert.content' => "\"$division->position\" masih dipakai dalam data user",
                'alert.type'    => 'error',
            ]);
        }
    }
}
