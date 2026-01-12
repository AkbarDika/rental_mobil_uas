<?php

namespace App\Http\Controllers;

use App\Models\KategoriMobil;
use Illuminate\Http\Request;

class KategoriMobilController extends Controller
{
    public function index()
    {
        $kategori = KategoriMobil::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required'
        ]);

        KategoriMobil::create($request->all());

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriMobil::findOrFail($id);

        $kategori->update($request->all());

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        KategoriMobil::findOrFail($id)->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }

}

