# Setup Localtunnel untuk Midtrans Callback (Alternative)

Karena Ngrok diblokir atau mengalami gangguan, kita akan menggunakan **Localtunnel**. Localtunnel tidak memerlukan pendaftaran akun dan installasi yang rumit (cukup via Node.js).

## 1. Pastikan Node.js Terinstall

Cek apakah Node.js sudah terinstall dengan menjalankan perintah ini di terminal:
```bash
cmd /c npm -v
```
Jika muncul versi (contoh: 10.9.3), lanjut ke langkah berikutnya.

## 2. Jalankan Localtunnel

Jalankan perintah berikut untuk mengekspos aplikasi Anda ke internet. 

**PENTING:** Gunakan Command Prompt (cmd) biasa, atau gunakan syntax `cmd /c` jika di PowerShell/Terminal VSCode agar tidak error policy.

```bash
cmd /c npx localtunnel --port 8000
```
*(Ganti 8000 dengan port `php artisan serve` Anda. Jika menggunakan XAMPP/Laragon, gunakan port 80)*

Setelah dijalankan, Anda akan mendapatkan URL seperti:
`https://quick-fox-22.loca.lt`

Copy URL tersebut.

**Tips:** Agar URL tidak berubah-ubah saat restart, Anda bisa request subdomain khusus (jika tersedia):
```bash
cmd /c npx localtunnel --port 8000 --subdomain namarentalanda
```

## 3. Bypass Halaman Warning (PENTING)

Localtunnel memiliki halaman keamanan saat pertama kali dibuka ("Click to Continue"). Ini akan **memblokir** callback Midtrans.

Untuk mengatasinya, Midtrans perlu mengirim header khusus `Bypass-Tunnel-Reminder`. Namun kita tidak bisa meminta Midtrans mengirim header itu.

**Solusi:**
Kita akan menggunakan layanan alternatif lain jika Localtunnel masih bermasalah dengan halaman warning ini. Coba akses URL Localtunnel di browser Anda sendiri terlebih dahulu dan klik "Continue". (Metode ini kurang reliable untuk webhook otomatis).

### REFERENSI ALTERNATIF LAIN: Serveo.net (Lebih Recommended untuk Webhook)

Jika Localtunnel sulit digunakan karena warning page, gunakan **Serveo**. Tidak perlu install apa-apa, cukup SSH.

Jalankan di terminal (PowerShell/CMD bisa):

```bash
ssh -R 80:127.0.0.1:8000 serveo.net
```
*(Jika diminta `Are you sure...`, ketik `yes`)*

**PENTING: Gunakan `127.0.0.1` daripada `localhost` untuk menghindari error 502.**

Anda akan mendapat URL misal: `https://abcd.serveo.net`

**Gunakan URL Serveo ini untuk Midtrans karena lebih stabil dan tidak ada warning page.**

## 4. Update Konfigurasi Midtrans

1. Login ke [Dashboard Midtrans Sandbox](https://dashboard.sandbox.midtrans.com/).
2. Masuk ke menu **Settings** > **Configuration**.
3. Update **Notification URL** dengan URL baru Anda.
   
   Contoh (Localtunnel):
   `https://namarentalanda.loca.lt/midtrans/callback`
   
   Atau Contoh (Serveo - RECOMMENDED):
   `https://abcd.serveo.net/midtrans/callback`

4. Klik **Update**.

## 5. Testing

Sama seperti sebelumnya, lakukan transaksi baru menggunakan URL publik tersebut.
