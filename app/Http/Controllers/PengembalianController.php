<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with('pemesanan')->get();
        $pemesanan = Pemesanan::all();

        return view('admin.pengembalian.index', compact('pengembalian', 'pemesanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pemesanan_id' => 'required',
            'tanggal_kembali' => 'required|date',
            'kondisi_mobil' => 'required',
            'status_pengembalian' => 'required'
        ]);

        Pengembalian::create($request->all());

        return redirect()->back()->with('success', 'Data pengembalian berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        $request->validate([
            'pemesanan_id' => 'required',
            'tanggal_kembali' => 'required|date',
            'kondisi_mobil' => 'required',
            'status_pengembalian' => 'required'
        ]);

        $pengembalian->update($request->all());

        return redirect()->back()->with('success', 'Data pengembalian berhasil diperbarui');
    }

    public function destroy($id)
    {
        Pengembalian::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data pengembalian berhasil dihapus');
    }
}
