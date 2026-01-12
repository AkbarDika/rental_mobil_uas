<?php

// File untuk test callback Midtrans secara manual
// Jalankan: php artisan tinker < test_callback.php
// Atau copy paste code ini ke dalam `php artisan tinker`

use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Http\Controllers\MidtransController;
use Illuminate\Http\Request;

// Simulasi callback dari Midtrans
// Ganti order_id sesuai pemesanan yang ada di database
$orderId = 'ORDER-1'; // Ganti dengan order ID yang ada

// Data dummy callback dari Midtrans
$data = [
    'order_id' => $orderId,
    'transaction_status' => 'settlement', // settlement, capture, pending, deny, cancel, expire
    'payment_type' => 'bank_transfer',
    'gross_amount' => 100000,
];

// Simulate POST request
$request = new Request($data);
$controller = new MidtransController();
$response = $controller->callback($request);

echo "Callback response: " . $response->getContent() . "\n";
echo "Status code: " . $response->getStatusCode() . "\n";

// Check database
$pembayaran = Pembayaran::where('pemesanan_id', str_replace('ORDER-', '', $orderId))->first();
if ($pembayaran) {
    echo "\n✅ Pembayaran berhasil disimpan!\n";
    echo "ID: " . $pembayaran->id . "\n";
    echo "Metode: " . $pembayaran->metode_pembayaran . "\n";
    echo "Jumlah: " . $pembayaran->jumlah_bayar . "\n";
    echo "Status: " . $pembayaran->status . "\n";
} else {
    echo "\n❌ Pembayaran tidak tersimpan\n";
}

