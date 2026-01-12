#!/usr/bin/env php
<?php
/**
 * Script untuk test Midtrans Callback secara manual
 * Jalankan: php debug_callback.php
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

use App\Models\Pemesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Http\Controllers\MidtransController;

// Get Laravel app instance
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "\n=== TEST MIDTRANS CALLBACK ===\n\n";

// Ambil pemesanan terakhir yang belum dibayar
$pemesanan = Pemesanan::where('status_pemesanan', '!=', 'dibayar')
    ->orderByDesc('id')
    ->first();

if (!$pemesanan) {
    echo "❌ Tidak ada pemesanan yang belum dibayar\n";
    exit(1);
}

echo "✅ Ditemukan Pemesanan:\n";
echo "   ID: " . $pemesanan->id . "\n";
echo "   Total: Rp " . number_format($pemesanan->total_harga, 0, ',', '.') . "\n";
echo "   Status: " . $pemesanan->status_pemesanan . "\n\n";

// Simulasi data callback Midtrans
$callbackData = [
    'order_id' => 'ORDER-' . $pemesanan->id,
    'transaction_status' => 'settlement',
    'payment_type' => 'bca_va',
    'gross_amount' => $pemesanan->total_harga,
    'transaction_id' => 'test-' . time(),
];

echo "📤 Mengirim simulasi callback:\n";
echo "   Order ID: " . $callbackData['order_id'] . "\n";
echo "   Status: " . $callbackData['transaction_status'] . "\n";
echo "   Metode: " . $callbackData['payment_type'] . "\n";
echo "   Jumlah: " . $callbackData['gross_amount'] . "\n\n";

// Buat request
$request = new Request($callbackData);

// Panggil controller
$controller = new MidtransController();

try {
    $response = $controller->callback($request);
    echo "📥 Response dari callback:\n";
    echo "   Status Code: " . $response->getStatusCode() . "\n";
    echo "   Body: " . $response->getContent() . "\n\n";
    
    // Check database
    echo "🔍 Mengecek database pembayaran...\n";
    $pembayaran = Pembayaran::where('pemesanan_id', $pemesanan->id)->first();
    
    if ($pembayaran) {
        echo "\n✅ SUKSES! Data pembayaran tersimpan:\n";
        echo "   ID: " . $pembayaran->id . "\n";
        echo "   Pemesanan ID: " . $pembayaran->pemesanan_id . "\n";
        echo "   Metode: " . $pembayaran->metode_pembayaran . "\n";
        echo "   Jumlah: Rp " . number_format($pembayaran->jumlah_bayar, 0, ',', '.') . "\n";
        echo "   Tanggal: " . $pembayaran->tanggal_bayar . "\n";
        echo "   Status: " . $pembayaran->status . "\n";
    } else {
        echo "\n❌ GAGAL! Data pembayaran tidak tersimpan di database\n";
        echo "   Cek apakah ada error di logs: storage/logs/laravel.log\n";
    }
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n";
    exit(1);
}

echo "\n";
?>
