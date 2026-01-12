# 🧪 Testing Form Pemesanan

## ✅ Database Setup
```
✅ Database refreshed dengan migrate:fresh --seed
✅ Semua tabel sudah dibuat (termasuk sessions)
✅ Test data sudah di-seed
```

---

## 👤 Test User Credentials

### Customer User
```
Username: customer1
Password: password
Role: Customer (role_id: 3)
Email: customer1@mail.com
```

### Admin User
```
Username: superadmin
Password: password
Role: Super Admin (role_id: 1)
Email: superadmin@mail.com
```

---

## 📝 Test Data

### Mobil
```
ID: 1 - Honda Jazz
  - Harga: Rp 300.000/hari
  - Tahun: 2023
  - Kursi: 5
  - Bahan Bakar: Bensin

ID: 2 - Toyota Avanza
  - Harga: Rp 350.000/hari
  - Tahun: 2023
  - Kursi: 7
  - Bahan Bakar: Bensin

ID: 3 - Nissan Livina
  - Harga: Rp 280.000/hari
  - Tahun: 2022
  - Kursi: 7
  - Bahan Bakar: Bensin
```

---

## 🎯 Testing Steps

### Step 1: Login
```
1. Buka http://127.0.0.1:8000/login
2. Masukkan username: customer1
3. Masukkan password: password
4. Klik Login
5. Seharusnya redirect ke /dashboard
```

### Step 2: Buka Form Pemesanan
```
Option A - Dari Katalog:
1. Buka http://127.0.0.1:8000/catalog
2. Klik "Pesan Sekarang" pada salah satu mobil
3. Seharusnya buka form: http://127.0.0.1:8000/rental/1

Option B - Direct URL:
1. Buka http://127.0.0.1:8000/rental/1 (untuk mobil ID 1)
2. Seharusnya menampilkan form pemesanan
```

### Step 3: Isi Form
```
Tanggal Mulai: 8 Januari 2026 (atau hari depan)
Tanggal Selesai: 10 Januari 2026 (atau 2 hari setelah mulai)
(Catatan: lokasi_pickup, lokasi_kembali, catatan sudah dihapus)
```

### Step 4: Submit Form
```
1. Klik "Konfirmasi Pemesanan"
2. Seharusnya:
   - Form valid
   - Insert ke 2 tabel: pemesanan + detail_pemesanan
   - Redirect ke /dashboard
   - Muncul success message: "Pemesanan berhasil dibuat! ID Pemesanan: #1"
```

---

## 🐛 Debugging

### Check Database
```bash
# Login ke MySQL
mysql -u root -p rental_mobil

# Check pemesanan
SELECT * FROM pemesanan;

# Check detail_pemesanan
SELECT * FROM detail_pemesanan;

# Check dengan join
SELECT 
  p.id,
  u.name as user_name,
  p.tanggal_mulai,
  p.tanggal_selesai,
  p.total_harga,
  p.status,
  dp.mobil_id,
  m.merk,
  m.model,
  dp.lama_sewa,
  dp.harga_per_hari
FROM pemesanan p
JOIN users u ON p.user_id = u.id
JOIN detail_pemesanan dp ON p.id = dp.pemesanan_id
JOIN mobil m ON dp.mobil_id = m.id;
```

### Check Laravel Logs
```bash
tail -f storage/logs/laravel.log
```

### Check Sessions
```bash
SELECT * FROM sessions;
```

---

## ✅ Expected Database State After Submit

### pemesanan table
```
ID  | user_id | tanggal_pesan | tanggal_mulai | tanggal_selesai | total_harga | status
----|---------|---------------|---------------|-----------------|-------------|--------
1   | 3       | 2026-01-07    | 2026-01-08    | 2026-01-10      | 600000      | pending
```

### detail_pemesanan table
```
ID  | pemesanan_id | mobil_id | lama_sewa | harga_per_hari | subtotal
----|--------------|----------|-----------|----------------|----------
1   | 1            | 1        | 2         | 300000         | 600000
```

---

## 🔄 Controller Flow

### RentalController@create
```php
GET /rental/1
  ↓
Check: User authenticated? ✅
  ↓
Get Car data (ID 1) ✅
  ↓
Return view: rental/create.blade.php dengan $car
  ↓
Form displayed ✅
```

### RentalController@store
```php
POST /rental
  ↓
Validate input:
  - mobil_id exists in mobil table ✅
  - tanggal_mulai is date after today ✅
  - tanggal_selesai is date after tanggal_mulai ✅
  ↓
Get Car data ✅
  ↓
Calculate:
  - lama_sewa = diffInDays ✅
  - harga_per_hari = car.harga_sewa ✅
  - subtotal = lama_sewa × harga_per_hari ✅
  ↓
DB::transaction:
  1. Create Pemesanan ✅
  2. Create DetailPemesanan ✅
  ↓
Return redirect(/dashboard) with success ✅
```

---

## 📊 Form Fields

### Input Fields
```
mobil_id (hidden) ← Dari URL parameter
tanggal_mulai (date) ← User input
tanggal_selesai (date) ← User input
```

### Removed Fields
```
❌ lokasi_pickup (tidak ada di database)
❌ lokasi_kembali (tidak ada di database)
❌ catatan (tidak ada di database)
```

### Auto-Calculate (JavaScript)
```
- Durasi: tanggal_selesai - tanggal_mulai
- Total: durasi × harga_per_hari
- Display: "X hari × Rp Y"
```

---

## ✨ Features

✅ Real-time price calculation
✅ Date validation (client + server)
✅ 2-table transaction insert
✅ Success/error messages
✅ Responsive design
✅ Bootstrap styling
✅ Icon integration
✅ Breadcrumb navigation

---

## 📌 Important Notes

1. **Sessions Table**: Sekarang sudah ada dari migrate:fresh --seed
2. **Transaction**: Both pemesanan dan detail_pemesanan akan insert atomically
3. **Validation**: Tanggal_selesai harus > tanggal_mulai (validated both client & server)
4. **Ownership**: Setiap pemesanan linked ke user yang login
5. **Pricing**: Auto-calculate dari durasi × harga_per_hari mobil

---

**Status:** ✅ READY FOR TESTING
**Last Updated:** January 7, 2026

