# Setup Ngrok untuk Midtrans Callback (Localhost)

Midtrans **memerlukan URL publik** untuk mengirim notifikasi status pembayaran (callback/webhook). Karena `localhost` tidak bisa diakses dari internet, kita perlu menggunakan tunneling service seperti **Ngrok**.

## 1. Install Ngrok

Jika belum punya Ngrok:
1. Daftar di [dashboard.ngrok.com](https://dashboard.ngrok.com/signup).
2. Download Ngrok untuk Windows.
3. Extract file zip.
4. Buka terminal/cmd di folder hasil extract.
5. Connect account Anda (token ada di dashboard Ngrok):
   ```bash
   ngrok config add-authtoken <YOUR_TOKEN>
   ```

## 2. Jalankan Ngrok

Jalankan perintah berikut untuk mengekspos web server lokal Anda ke internet.

**Jika menggunakan `php artisan serve` (Default Port 8000):**
```bash
ngrok http 8000
```

**Jika menggunakan Nginx/Laragon/XAMPP (Port 80):**
```bash
ngrok http 80
```

Setelah dijalankan, Anda akan mendapatkan URL publik, contohnya:
`https://a1b2-c3d4.ngrok-free.app` -> `http://localhost:8000`

Copy URL `https://...` tersebut.

## 3. Update Konfigurasi Midtrans

1. Login ke [Dashboard Midtrans Sandbox](https://dashboard.sandbox.midtrans.com/).
2. Masuk ke menu **Settings** > **Configuration**.
3. Pada bagian **Notification URL**, masukkan URL Ngrok Anda ditambah `/midtrans/callback`.
   
   Contoh:
   `https://a1b2-c3d4.ngrok-free.app/midtrans/callback`

4. Klik **Update**.

## 4. Testing

1. Buka aplikasi rental mobil Anda menggunakan URL Ngrok (bukan localhost).
   Contoh: `https://a1b2-c3d4.ngrok-free.app`
2. Lakukan transaksi penyewaan mobil.
3. Pilih metode pembayaran dan selesaikan di Simulator Midtrans.
4. Cek terminal Ngrok, pastikan ada request `POST /midtrans/callback 200 OK`.
5. Cek status order di aplikasi Anda.

> **Catatan:** URL Ngrok versi gratis akan berubah setiap kali Anda restart Ngrok. Jadi Anda perlu update Notification URL di Midtrans setiap kali menjalankan ulang Ngrok.
