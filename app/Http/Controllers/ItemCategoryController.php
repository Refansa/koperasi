<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ItemCategory::all();

        return inertia('admin.items.categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('admin.items.categories.create');
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
            'category' => ['required', 'string', 'unique:item_categories'],
        ]);

        ItemCategory::create($data);

        return redirect()->route('admin.items.categories.index')->with([
            'alert.content' => 'Kategori berhasil dibuat',
            'alert.type'    => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ItemCategory $itemCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemCategory $itemCategory)
    {
        return inertia('admin.items.categories.edit', [
            'item_category' => $itemCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemCategory $itemCategory)
    {
        $data = $request->validate([
            'category' => ['required', 'string', 'unique:item_categories'],
        ]);

        $itemCategory->update($data);

        return redirect()->route('admin.items.categories.index')->with([
            'alert.content' => 'Kategori berhasil diubah',
            'alert.type'    => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemCategory $itemCategory)
    {
        ItemCategory::destroy($itemCategory->id);

        return back()->with([
            'alert.content' => 'Kategori berhasil dihapus',
            'alert.type'    => 'success',
        ]);
    }
}
