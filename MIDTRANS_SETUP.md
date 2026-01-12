# Setup Payment Gateway Midtrans

## Apa yang sudah diperbaiki:

### 1. **Konfigurasi Midtrans (config/midtrans.php)**
   - ✅ Menggunakan environment variables yang benar
   - ✅ Server Key dan Client Key tidak terbalik lagi
   - ✅ Konfigurasi untuk sandbox mode (is_production=false)

### 2. **MidtransController (app/Http/Controllers/MidtransController.php)**
   - ✅ Menambah Config::__construct() untuk setup Midtrans
   - ✅ Import Config class yang benar
   - ✅ Error handling untuk validasi order
   - ✅ Cek duplikasi pembayaran (tidak double charge)
   - ✅ Handle semua status transaksi: settlement, capture, pending, deny, cancel, expire
   - ✅ Update status pemesanan sesuai payment status
   - ✅ Log error untuk debugging

### 3. **Routes (routes/web.php)**
   - ✅ Webhook callback bypass CSRF protection
   - ✅ Callback tidak memerlukan autentikasi (endpoint public)

### 4. **.env Configuration**
   - ✅ Tambah MIDTRANS_SERVER_KEY
   - ✅ Tambah MIDTRANS_CLIENT_KEY
   - ✅ Tambah MIDTRANS_IS_PRODUCTION flag

---

## Cara Setup Midtrans (Langkah-Langkah)

### **Step 1: Buat Akun Midtrans**
1. Buka https://dashboard.sandbox.midtrans.com
2. Sign up dengan email Anda
3. Verifikasi email

### **Step 2: Dapatkan API Keys**
1. Login ke dashboard Midtrans
2. Pergi ke **Settings → Configuration**
3. Copy:
   - **Server Key** (ganti MIDTRANS_SERVER_KEY di .env)
   - **Client Key** (ganti MIDTRANS_CLIENT_KEY di .env)

### **Step 3: Update .env File**
```env
MIDTRANS_SERVER_KEY=Mid-server-xxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=Mid-client-xxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
```

⚠️ **Penting:**
- Gunakan **Sandbox** untuk development (false)
- Gunakan **Production** hanya untuk live (true)
- Jangan commit credentials ke git! Gunakan .env saja

### **Step 4: Clear Cache**
```bash
php artisan config:cache
```

### **Step 5: Setup Webhook di Midtrans**
1. Dashboard Midtrans → Settings → Configuration
2. Cari **Notification URL**
3. Set ke: `https://yourdomain.com/midtrans/callback`
4. Gunakan **POST** method

---

## Cara Kerja Payment Flow

```
User klik "Bayar" 
    ↓
PemesananController generate Snap Token
    ↓
Frontend tampilkan Snap Payment Dialog
    ↓
User pilih metode pembayaran (CC, Transfer, dll)
    ↓
User complete pembayaran di Midtrans
    ↓
Midtrans kirim callback ke /midtrans/callback
    ↓
MidtransController create Pembayaran record
    ↓
Update status Pemesanan = "dibayar"
```

---

## Status Transaksi yang Ditangani

| Status Midtrans | Aksi | Status Pembayaran |
|-----------------|------|------------------|
| `settlement` | Create pembayaran, update pemesanan | ✅ success |
| `capture` | Create pembayaran, update pemesanan | ✅ success |
| `pending` | Create pembayaran | ⏳ pending |
| `deny` | Create pembayaran, cancel pemesanan | ❌ failed |
| `cancel` | Create pembayaran, cancel pemesanan | ❌ failed |
| `expire` | Create pembayaran, cancel pemesanan | ❌ failed |

---

## Testing Payment dengan Sandbox

### **Kartu Kredit Test**
- **Card Number:** 4111 1111 1111 1111
- **Exp Month:** 12
- **Exp Year:** 2025
- **CVV:** 123

### **Test Scenarios**
- **Approve:** Gunakan nomor kartu di atas dengan OTP apapun
- **Deny:** Input CVV yang salah
- **Pending:** Gunakan e-wallet atau bank transfer

---

## Troubleshooting

### **Error: "Invalid Credentials"**
```bash
php artisan config:cache
php artisan config:clear
# Pastikan MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY benar di .env
```

### **Error: "Notification not verified"**
- Pastikan Webhook URL benar di dashboard Midtrans
- Pastikan route `/midtrans/callback` accessible (public)
- Check logs: `storage/logs/laravel.log`

### **Error: "Order not found"**
- Pastikan order_id format: `ORDER-{pemesanan.id}`
- Cek database apakah pemesanan sudah exist

### **Double Charge Issue**
- ✅ Sudah dihandle dengan cek `existingPayment`
- Webhook callback hanya diproses sekali

---

## File yang Diubah

✅ `config/midtrans.php` - Konfigurasi
✅ `app/Http/Controllers/MidtransController.php` - Payment callback logic
✅ `routes/web.php` - Webhook route
✅ `.env` - Environment variables

---

## Next Steps (Optional Enhancement)

1. **Email Notification:** Kirim email ke user ketika pembayaran berhasil
2. **Payment History:** Buat halaman untuk lihat history pembayaran
3. **Refund Logic:** Implementasikan proses refund untuk pembatalan
4. **Cronjob Check:** Implement payment status checking setiap jam
5. **Dashboard Metrics:** Tampilkan grafik pembayaran di admin panel

---

## Resources

- 📚 [Midtrans Documentation](https://docs.midtrans.com/)
- 📚 [Midtrans PHP Library](https://github.com/Midtrans/midtrans-php)
- 🎓 [Laravel Integration Guide](https://docs.midtrans.com/en/snap/integration-guide?lang=php)
