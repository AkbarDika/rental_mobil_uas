<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    /**
     * Dashboard petugas
     */
    public function index()
    {
        // Statistik untuk dashboard
        $totalPemesananPending = Pemesanan::where('status', 'pending')->count();
        $totalPemesananDisetujuiHariIni = Pemesanan::where('status', 'disetujui')
            ->whereDate('updated_at', today())
            ->count();
        
        $totalPengembalianPending = Pengembalian::where('status_pengembalian', 'pending')->count();
        $totalPengembalianSelesaiHariIni = Pengembalian::where('status_pengembalian', 'selesai')
            ->whereDate('updated_at', today())
            ->count();

        // Data terbaru
        $pemesananTerbaru = Pemesanan::with(['user', 'details.mobil', 'pembayaran', 'pengembalian'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $pengembalianTerbaru = Pengembalian::with(['pemesanan.user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('petugas.index', compact(
            'totalPemesananPending',
            'totalPemesananDisetujuiHariIni',
            'totalPengembalianPending',
            'totalPengembalianSelesaiHariIni',
            'pemesananTerbaru',
            'pengembalianTerbaru'
        ));
    }

    /**
     * Halaman daftar pemesanan
     */
    public function pemesanan()
    {
        $pemesanan = Pemesanan::with(['user', 'details.mobil', 'pembayaran', 'pengembalian'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('petugas.pemesanan.index', compact('pemesanan'));
    }

    /**
     * Konfirmasi/update status pemesanan
     */
    public function konfirmasiPemesanan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,disetujui,ditolak,selesai'
        ]);

        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pemesanan berhasil diupdate');
    }

    /**
     * Halaman daftar pengembalian
     */
    public function pengembalian()
    {
        $pengembalian = Pengembalian::with(['pemesanan.user', 'pemesanan.details.mobil'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('petugas.pengembalian.index', compact('pengembalian'));
    }

    /**
     * Konfirmasi/update status pengembalian
     */
    public function konfirmasiPengembalian(Request $request, $id)
    {
        $request->validate([
            'status_pengembalian' => 'required|in:pending,selesai,bermasalah'
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->update([
            'status_pengembalian' => $request->status_pengembalian
        ]);

        return redirect()->back()->with('success', 'Status pengembalian berhasil diupdate');
    }
}
