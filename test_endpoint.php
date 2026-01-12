#!/usr/bin/env php
<?php
/**
 * Test apakah endpoint callback accessible
 * Jalankan: php test_endpoint.php
 */

require __DIR__ . '/vendor/autoload.php';

// Data simulasi callback dari Midtrans
$data = [
    'order_id' => 'ORDER-1',
    'transaction_status' => 'settlement',
    'payment_type' => 'bca_va',
    'gross_amount' => 100000,
];

echo "\n=== TEST ENDPOINT CALLBACK ===\n\n";
echo "Testing endpoint: http://localhost:8000/midtrans/callback\n";
echo "Method: POST\n\n";

// Gunakan cURL untuk test
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/midtrans/callback');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
]);

echo "Sending data:\n";
echo json_encode($data, JSON_PRETTY_PRINT) . "\n\n";

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "Response:\n";
echo "HTTP Code: " . $httpCode . "\n";
echo "Body: " . $response . "\n\n";

if ($error) {
    echo "❌ ERROR: " . $error . "\n";
} elseif ($httpCode === 200) {
    echo "✅ Success! Endpoint accessible\n";
} else {
    echo "⚠️ HTTP " . $httpCode . " - Check server logs\n";
}

echo "\n";
?>
