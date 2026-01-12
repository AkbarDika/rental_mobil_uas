<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Http\Controllers\MidtransController;

class TestCallbackController extends Controller
{
    /**
     * Halaman test callback (hanya untuk development)
     */
    public function index()
    {
        // Ambil pemesanan yang belum dibayar
        $pemesanans = Pemesanan::where('status', '!=', 'disetujui')
            ->orderByDesc('id')
            ->get();

        return view('test.midtrans_callback', compact('pemesanans'));
    }

    /**
     * Simulasi callback dari Midtrans
     */
    public function simulateCallback(Request $request)
    {
        $validated = $request->validate([
            'pemesanan_id' => 'required|exists:pemesanan,id',
            'transaction_status' => 'required|in:settlement,capture,pending,deny,cancel,expire',
            'payment_type' => 'required|string',
        ]);

        try {
            $pemesanan = Pemesanan::find($validated['pemesanan_id']);

            // Cek apakah pembayaran sudah ada
            $existingPayment = \App\Models\Pembayaran::where('pemesanan_id', $pemesanan->id)->first();
            if ($existingPayment) {
                return back()->with('error', 'Pembayaran untuk pesanan ini sudah pernah diproses');
            }

            // Terjemahkan payment type
            $metodeMap = [
                'bank_transfer' => 'Transfer Bank',
                'bca_va' => 'BCA VA',
                'bni_va' => 'BNI VA',
                'cimb_va' => 'CIMB VA',
                'permata_va' => 'Permata VA',
                'credit_card' => 'Kartu Kredit',
                'gopay' => 'GoPay',
                'ovo' => 'OVO',
            ];

            $metodeDisplayName = $metodeMap[$validated['payment_type']] ?? ucwords(str_replace('_', ' ', $validated['payment_type']));

            // Simulasi callback
            if ($validated['transaction_status'] == 'settlement' || $validated['transaction_status'] == 'capture') {
                \App\Models\Pembayaran::create([
                    'pemesanan_id' => $pemesanan->id,
                    'metode_pembayaran' => $metodeDisplayName,
                    'tanggal_bayar' => now()->toDateString(),
                    'jumlah_bayar' => $pemesanan->total_harga,
                    'status' => 'valid',
                ]);

                $pemesanan->update(['status' => 'disetujui']);

                return back()->with('success', 
                    "✅ Callback simulasi berhasil! " .
                    "Pemesanan #" . $pemesanan->id . " dengan status: " . $validated['transaction_status']
                );
            } elseif ($validated['transaction_status'] == 'pending') {
                \App\Models\Pembayaran::create([
                    'pemesanan_id' => $pemesanan->id,
                    'metode_pembayaran' => $metodeDisplayName,
                    'tanggal_bayar' => now()->toDateString(),
                    'jumlah_bayar' => $pemesanan->total_harga,
                    'status' => 'menunggu',
                ]);

                return back()->with('success', 
                    "⏳ Pembayaran PENDING - Menunggu konfirmasi transfer"
                );
            } else {
                // deny, cancel, expire
                \App\Models\Pembayaran::create([
                    'pemesanan_id' => $pemesanan->id,
                    'metode_pembayaran' => $metodeDisplayName,
                    'tanggal_bayar' => now()->toDateString(),
                    'jumlah_bayar' => $pemesanan->total_harga,
                    'status' => 'ditolak',
                ]);

                $pemesanan->update(['status' => 'ditolak']);

                return back()->with('success', 
                    "❌ Pembayaran GAGAL/DIBATALKAN"
                );
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
