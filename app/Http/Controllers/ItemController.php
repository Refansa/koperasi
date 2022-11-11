<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        $items->load('supplier');

        return inertia('admin.items.index', [
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::all();

        return inertia('admin.items.create', [
            'suppliers' => $suppliers,
        ]);
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
            'name'      => ['required', 'string'],
            'supplier'  => ['required', 'numeric'],
            'stock'     => ['required', 'numeric'],
            'price'     => ['required', 'numeric'],
        ]);

        $supplier = Supplier::find($data['supplier']);
        unset($data['supplier']);

        $item = new Item($data);

        $supplier->items()->save($item);

        return redirect()->route('admin.items.index')->with([
            'alert.content' => 'Barang berhasil dibuat',
            'alert.type'    => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $suppliers = Supplier::all();
        $item->load('supplier');

        return inertia('admin.items.edit', [
            'item' => $item,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'name'      => ['required', 'string'],
            'supplier'  => ['required', 'numeric'],
            'stock'     => ['required', 'numeric'],
            'price'     => ['required', 'numeric'],
        ]);

        $supplier = Supplier::find($data['supplier']);
        $data['supplier_id'] = $supplier->id;
        unset($data['supplier']);

        $item->update($data);

        return redirect()->route('admin.items.index')->with([
            'alert.content' => 'Barang berhasil diubah',
            'alert.type'    => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        Item::destroy($item->id);

        return back()->with([
            'alert.content' => 'Barang berhasil dihapus',
            'alert.type'    => 'success',
        ]);
    }
}
