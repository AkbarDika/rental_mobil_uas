<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PemesananController extends Controller
{
    public function index()
    {
        $pemesanan = Pemesanan::with([
            'user',
            'details.mobil'
        ])->get();

        $users = User::all();

        return view('admin.orders.index', compact('pemesanan', 'users'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'total_harga' => 'required|numeric',
            'status' => 'required'
        ]);

        Pemesanan::create([
            'user_id' => $request->user_id,
            'tanggal_pesan' => now(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'total_harga' => $request->total_harga,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Pemesanan berhasil ditambahkan');
    }


    public function update(Request $request, Pemesanan $pemesanan)
    {
        $request->validate([
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'total_harga'     => 'required|numeric',
            'status'          => 'required'
        ]);

        DB::transaction(function () use ($request, $pemesanan) {

            $mulai   = Carbon::parse($request->tanggal_mulai);
            $selesai = Carbon::parse($request->tanggal_selesai);

            $lamaSewa = $mulai->diffInDays($selesai);

            /* UPDATE PEMESANAN */
            $pemesanan->update([
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'total_harga'     => $request->total_harga,
                'status'          => $request->status
            ]);

            /* UPDATE DETAIL PEMESANAN (PAKSA) */
            $updated = $pemesanan->details()->update([
                'lama_sewa' => $lamaSewa,
                'subtotal'  => $request->total_harga
            ]);

            // optional debug
            // logger('detail updated rows: '.$updated);
        });

        return redirect()->back()->with('success', 'Pemesanan & detail berhasil diperbarui');
    }



    public function destroy(Pemesanan $pemesanan)
    {
        DB::transaction(function () use ($pemesanan) {
            $pemesanan->details()->delete(); // hapus detail dulu
            $pemesanan->delete();            // baru hapus pemesanan
        });

        return redirect()->back()->with('success', 'Pemesanan & detail berhasil dihapus');
    }


    /* DETAIL */
    public function show(Pemesanan $pemesanan)
    {
        return view('admin.pemesanan.detail', compact('pemesanan'));
    }
}
