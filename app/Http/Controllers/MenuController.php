<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * TAMPIL MENU
     */
    public function index()
    {
        $menus = Menu::all();

        return view('menu.index', compact('menus'));
    }

    /**
     * FORM TAMBAH
     */
    public function create()
    {
        return view('menu.create');
    }

    /**
     * SIMPAN MENU
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required',
            'gizi' => 'required',
            'status' => 'required',
            'gambar' => 'required|image'
        ]);

        // upload gambar
        $gambar = time().'.'.$request->gambar->extension();

        $request->gambar->move(
            public_path('images'),
            $gambar
        );

        // simpan database
        Menu::create([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'gizi' => $request->gizi,
            'status' => $request->status,
            'gambar' => $gambar
        ]);

        return redirect('/menu')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);

        return view('menu.edit', compact('menu'));
    }

    /**
     * UPDATE MENU
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        if($request->hasFile('gambar')){

            $gambar = time().'.'.$request->gambar->extension();

            $request->gambar->move(
                public_path('images'),
                $gambar
            );

            $menu->gambar = $gambar;
        }

        $menu->nama_menu = $request->nama_menu;
        $menu->harga = $request->harga;
        $menu->gizi = $request->gizi;
        $menu->status = $request->status;

        $menu->save();

        return redirect('/menu')
            ->with('success', 'Menu berhasil diupdate');
    }

    /**
     * HAPUS MENU
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        $menu->delete();

        return redirect('/menu')
            ->with('success', 'Menu berhasil dihapus');
    }
}