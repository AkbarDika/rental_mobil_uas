# 🎯 Quick Start: Fitur Pemesanan Mobil

## ⚡ Cara Menggunakan

### 1. **User Membaca Katalog**
```
http://127.0.0.1:8000/catalog
↓
Pilih mobil → Klik tombol "Pesan Sekarang"
```

### 2. **Atau dari Dashboard**
```
http://127.0.0.1:8000/dashboard
↓
Section "Best Seller" → Klik "Sewa Sekarang"
```

### 3. **Atau dari Detail Mobil**
```
http://127.0.0.1:8000/catalog/{carId}
↓
Klik tombol "Pesan Sekarang"
```

### 4. **Form Pemesanan Terbuka**
```
URL: http://127.0.0.1:8000/rental/{carId}
```

---

## 📝 Cara Mengisi Form

### **Kolom Tanggal Sewa**
- Klik field → Date picker terbuka
- Pilih tanggal mulai sewa (min: hari ini)
- Estimasi harga akan otomatis update

### **Kolom Tanggal Kembali**
- Klik field → Date picker terbuka
- Pilih tanggal pengembalian (min: setelah tanggal sewa)
- Estimasi harga update dengan durasi benar

### **Lokasi Pickup**
```
Opsi:
- Pusat Bandara
- Bandara Husein Sastranegara
- Pusat Kota Bandung
- Stasiun Bandung
- Hotel (Sesuai lokasi hotel)
```

### **Lokasi Kembali**
```
Opsi:
- Pusat Bandara
- Bandara Husein Sastranegara
- Pusat Kota Bandung
- Stasiun Bandung
- Hotel (Sesuai lokasi hotel)
```

### **Catatan Tambahan (Opsional)**
- Tuliskan permintaan khusus
- Max 500 karakter
- Contoh: "Butuh GPS", "Upgrade ke AC double", dll

### **Tombol Aksi**
- **Konfirmasi Pemesanan** → Submit form
- **Kembali** → Kembali ke halaman sebelumnya

---

## 💰 Estimasi Harga

Sistem otomatis menghitung:

```
RUMUS:
Total Harga = (Tanggal Kembali - Tanggal Sewa) × Harga Per Hari

CONTOH:
- Mobil: Honda Jazz
- Harga per hari: Rp 500.000
- Tanggal Sewa: 7 Januari 2026
- Tanggal Kembali: 10 Januari 2026
- Durasi: 3 hari
- Total: 3 × 500.000 = Rp 1.500.000
```

Estimasi ditampilkan:
```
Estimasi Total
Rp 1.500.000
3 hari × Rp 500.000
```

---

## ✅ Validasi

### **Client-Side (Browser)**
```
✅ Tanggal sewa minimal hari ini
✅ Tanggal kembali harus setelah tanggal sewa
✅ Semua field required diisi
✅ Dropdown lokasi harus dipilih
✅ Error message muncul dengan styling Bootstrap
```

### **Server-Side (Laravel)**
```php
✅ car_id exists di tabel mobil
✅ tanggal_sewa after today
✅ tanggal_kembali after tanggal_sewa
✅ string fields max length
✅ catatan max 500 karakter
```

---

## 🔐 Keamanan

1. **Authentication Required**
   - Hanya user yang login bisa akses form
   - Tombol "Pesan Sekarang" redirect ke login jika belum login

2. **Authorization**
   - User hanya bisa lihat/edit pemesanan mereka sendiri
   - Cek: `Auth::user()->pemesanan()->findOrFail($id)`

3. **CSRF Protection**
   - Form auto-protect dengan `@csrf` Blade directive
   - Laravel meng-validate token secara otomatis

---

## 📨 Response Setelah Submit

### **Sukses**
```
Status: 302 Redirect
Tujuan: /dashboard
Message: "Pemesanan berhasil dibuat! ID Pemesanan: #123"
```

### **Error Validasi**
```
Status: 422 Unprocessable Entity
Response: Kembali ke form dengan error messages
Highlight: Field yang error ditunjukkan dengan border merah
```

---

## 📱 Responsive Design

### **Desktop (> 992px)**
```
┌─────────────────────────────────────┐
│         Breadcrumb                  │
├──────────┬──────────────────────────┤
│ Sidebar  │  Form Pemesanan          │
│ Mobil    │  • Tanggal Sewa          │
│ (Sticky) │  • Tanggal Kembali       │
│          │  • Lokasi Pickup         │
│          │  • Lokasi Kembali        │
│          │  • Catatan               │
│          │  [Tombol Konfirmasi]     │
├──────────┴──────────────────────────┤
│         Alert Info                  │
└─────────────────────────────────────┘
```

### **Mobile (< 992px)**
```
┌──────────────────────┐
│    Breadcrumb        │
├──────────────────────┤
│  Info Mobil          │
│  • Foto              │
│  • Harga/hari        │
│  Estimasi Total      │
├──────────────────────┤
│  Form Pemesanan      │
│  • Tanggal Sewa      │
│  • Tanggal Kembali   │
│  • Lokasi Pickup     │
│  • Lokasi Kembali    │
│  • Catatan           │
│  [Tombol]            │
├──────────────────────┤
│    Alert Info        │
└──────────────────────┘
```

---

## 🐛 Common Issues & Solutions

### Issue 1: "Silakan login terlebih dahulu"
**Penyebab:** User belum login
**Solusi:** Login di `/login` terlebih dahulu

### Issue 2: "404 Not Found"
**Penyebab:** Car ID tidak ada di database
**Solusi:** Pastikan ID mobil valid (1-999)

### Issue 3: Estimasi harga tidak muncul
**Penyebab:** JavaScript error atau date picker belum dipilih
**Solusi:** Pilih tanggal sewa dan kembali terlebih dahulu

### Issue 4: "Tanggal kembali harus setelah tanggal sewa"
**Penyebab:** Tanggal kembali <= tanggal sewa
**Solusi:** Pilih tanggal kembali yang lebih besar

---

## 🎬 Demo Scenario

**Nama User:** Budi Santoso
**Status:** Authenticated ✅
**Tujuan:** Sewa mobil untuk liburan keluarga

### **Step-by-Step:**

1. **Buka Katalog**
   ```
   http://127.0.0.1:8000/catalog
   ```

2. **Pilih Mobil**
   - Cari: "Honda Jazz" (Rp 500.000/hari)
   - Klik: "Pesan Sekarang"

3. **Form Pemesanan Terbuka**
   ```
   URL: http://127.0.0.1:8000/rental/1
   Sidebar: Menampilkan Honda Jazz
   ```

4. **Isi Form**
   | Field | Input |
   |-------|-------|
   | Tanggal Sewa | 7 Januari 2026 |
   | Tanggal Kembali | 10 Januari 2026 |
   | Lokasi Pickup | Bandara Husein Sastranegara |
   | Lokasi Kembali | Pusat Kota Bandung |
   | Catatan | Bawa anak 2 orang, mohon AC dingin |

5. **Lihat Estimasi**
   ```
   Estimasi Total: Rp 1.500.000
   3 hari × Rp 500.000
   ```

6. **Klik "Konfirmasi Pemesanan"**
   ```
   ✅ Form valid
   📤 POST /rental
   ✅ Pemesanan dibuat dengan ID #123
   🔄 Redirect ke /dashboard
   📧 Pesan: "Pemesanan berhasil dibuat! ID Pemesanan: #123"
   ```

7. **Success!**
   - Pemesanan #123 tersimpan di database
   - User bisa lihat di dashboard
   - Next step: Bayar melalui sistem pembayaran

---

## 💡 Tips & Tricks

- **Set Tanggal Cepat:** Double-click pada field date untuk membuka date picker
- **Lihat Estimasi Real-Time:** Harga otomatis update saat ganti tanggal
- **Catatan Penting:** Tulis semua kebutuhan spesial di catatan
- **Verifikasi Lokasi:** Pastikan lokasi pickup/kembali sama jika butuh antar-jemput

---

**Enjoy your rental experience! 🚗💨**

