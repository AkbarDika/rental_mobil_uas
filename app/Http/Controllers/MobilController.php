<?php

namespace App\Http\Controllers;

use App\Models\Car as Mobil;
use App\Models\KategoriMobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::with('kategori')->get();
        $kategori = KategoriMobil::all();

        return view('admin.cars.index', compact('mobils', 'kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_mobil,id',
            'merk'        => 'required',
            'model'       => 'required',
            'tahun'       => 'required|digits:4',
            'nomor_plat'  => 'required|unique:mobil,nomor_plat',
            'harga_sewa'  => 'required|numeric',
            'status'      => 'required',
        ]);

        Mobil::create($validated);

        return redirect()->back()->with('success', 'Mobil berhasil ditambahkan');
    }

    public function update(Request $request, Mobil $mobil)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_mobil,id',
            'merk'        => 'required',
            'model'       => 'required',
            'tahun'       => 'required|digits:4',
            'nomor_plat'  => 'required|unique:mobil,nomor_plat,' . $mobil->id,
            'harga_sewa'  => 'required|numeric',
            'status'      => 'required',
        ]);

        $mobil->update($validated);

        return redirect()->back()->with('success', 'Mobil berhasil diupdate');
    }

    public function destroy(Mobil $mobil)
    {
        $mobil->delete();
        return redirect()->back()->with('success', 'Mobil berhasil dihapus');
    }
}
