# Dokumentasi Sistem Pemesanan Mobil (Rental)

## 📋 Ringkasan
Sistem pemesanan mobil memungkinkan pelanggan (authenticated users) untuk memesan mobil dari katalog. Tombol "Pesan Sekarang" atau "Sewa Sekarang" akan membawa user ke form pemesanan lengkap dengan estimasi harga real-time.

## 🏗️ Arsitektur

### Controller: `RentalController`
**File:** `app/Http/Controllers/RentalController.php`

Menangani semua logika pemesanan:
- `create($carId)` - Menampilkan form pemesanan untuk mobil tertentu
- `store(Request $request)` - Menyimpan pemesanan baru ke database
- `show($pemesananId)` - Menampilkan detail pemesanan
- `edit($pemesananId)` - Menampilkan form edit pemesanan
- `update(Request $request, $pemesananId)` - Update pemesanan
- `cancel($pemesananId)` - Pembatalan pemesanan

### Model: `Pemesanan`
**File:** `app/Models/Pemesanan.php`

```php
protected $table = 'pemesanan';

protected $fillable = [
    'user_id',           // ID User yang melakukan pemesanan
    'car_id',            // ID Mobil yang dipesan
    'tanggal_sewa',      // Tanggal mulai sewa
    'tanggal_kembali',   // Tanggal pengembalian
    'lokasi_pickup',     // Lokasi pengambilan mobil
    'lokasi_kembali',    // Lokasi pengembalian mobil
    'total_harga',       // Harga total (auto-calculate)
    'status',            // pending, active, completed, cancelled
    'catatan',           // Catatan tambahan dari user
];
```

**Relationships:**
- `belongsTo(User::class)` - Pemesanan milik satu user
- `belongsTo(Car::class)` - Pemesanan untuk satu mobil

### View: Form Pemesanan
**File:** `resources/views/rental/create.blade.php`

Fitur-fitur:
- ✅ Layout responsive dengan sidebar info mobil dan form pemesanan
- ✅ Sticky sidebar dengan info mobil (foto, merk, model, harga/hari)
- ✅ Real-time estimasi harga (JavaScript)
- ✅ Form fields:
  - Tanggal Sewa (date picker, min: hari ini)
  - Tanggal Kembali (date picker, min: setelah tanggal sewa)
  - Lokasi Pickup (dropdown dengan 5 opsi lokasi)
  - Lokasi Kembali (dropdown dengan 5 opsi lokasi)
  - Catatan Tambahan (textarea, opsional)
- ✅ Validasi client-side Bootstrap
- ✅ Tombol Konfirmasi dan Kembali
- ✅ Info penting dan alert

## 🛣️ Routes

```php
// Dalam group middleware 'auth'
Route::get('/rental/{carId}', [RentalController::class, 'create'])
    ->name('rental.create');           // Form pemesanan

Route::post('/rental', [RentalController::class, 'store'])
    ->name('rental.store');            // Simpan pemesanan

Route::get('/rental/{pemesananId}/detail', [RentalController::class, 'show'])
    ->name('rental.show');             // Lihat detail

Route::get('/rental/{pemesananId}/edit', [RentalController::class, 'edit'])
    ->name('rental.edit');             // Edit form

Route::post('/rental/{pemesananId}', [RentalController::class, 'update'])
    ->name('rental.update');           // Update pemesanan

Route::post('/rental/{pemesananId}/cancel', [RentalController::class, 'cancel'])
    ->name('rental.cancel');           // Batalkan pemesanan
```

## 🔗 Integrasi dengan Halaman Lain

### 1. Katalog Index (`catalog/index.blade.php`)
Tombol "Pesan Sekarang" menggunakan link:
```blade
<a href="{{ route('rental.create', $car->id) }}" class="btn btn-outline-primary btn-sm w-100">
    <i class="bi bi-cart"></i> Pesan Sekarang
</a>
```

### 2. Katalog Detail (`catalog/show.blade.php`)
Tombol "Pesan Sekarang" menggunakan link:
```blade
<a href="{{ route('rental.create', $car->id) }}" class="btn btn-primary btn-lg mb-2">
    <i class="bi bi-calendar-check"></i> Pesan Sekarang
</a>
```
Modal booking lama dihapus dan diganti dengan halaman form lengkap.

### 3. Dashboard (`dashboard.blade.php`)
Tombol "Sewa Sekarang" pada best seller menggunakan link:
```blade
<a href="{{ route('rental.create', $car->id) }}" class="btn btn-primary mt-auto">
    Sewa Sekarang
</a>
```

## 📱 Fitur JavaScript

### Real-Time Price Calculation
```javascript
// Auto-hitung total harga saat tanggal berubah
tanggalSewaInput.addEventListener('change', hitungTotal);
tanggalKembaliInput.addEventListener('change', hitungTotal);

// Format dengan Intl.NumberFormat (id-ID)
const formatter = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
});
```

### Date Validation
- Min tanggal sewa: hari ini (`today`)
- Min tanggal kembali: setelah tanggal sewa
- Auto-set min date attributes pada input date

## 🔐 Security & Validation

### Backend Validation (RentalController@store)
```php
$validated = $request->validate([
    'car_id' => 'required|exists:mobil,id',
    'tanggal_sewa' => 'required|date|after:today',
    'tanggal_kembali' => 'required|date|after:tanggal_sewa',
    'lokasi_pickup' => 'required|string|max:255',
    'lokasi_kembali' => 'required|string|max:255',
    'catatan' => 'nullable|string|max:500',
]);
```

### Authorization
- Hanya authenticated users (middleware `auth`) yang bisa mengakses pemesanan
- Ownership check di controller: `Auth::user()->pemesanan()->findOrFail()`

## 💰 Kalkulasi Harga

Formula otomatis saat submit:
```php
$durasi = $tanggal_kembali->diffInDays($tanggal_sewa);
$total_harga = $durasi * $car->harga_sewa;
```

## 📊 Database Schema

Struktur tabel `pemesanan`:
```sql
CREATE TABLE pemesanan (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    car_id BIGINT NOT NULL,
    tanggal_sewa DATE NOT NULL,
    tanggal_kembali DATE NOT NULL,
    lokasi_pickup VARCHAR(255) NOT NULL,
    lokasi_kembali VARCHAR(255) NOT NULL,
    total_harga DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    catatan TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (car_id) REFERENCES mobil(id)
);
```

## 🧪 Testing Checklist

- [ ] Klik "Pesan Sekarang" dari katalog → Form terbuka dengan info mobil
- [ ] Form menampilkan nama, foto, harga mobil dengan benar
- [ ] Pilih tanggal sewa dan kembali → Estimasi harga update otomatis
- [ ] Pilih lokasi pickup dan kembali dari dropdown
- [ ] Submit form dengan data valid → Pemesanan berhasil disimpan
- [ ] Error validation muncul jika data invalid
- [ ] User harus login untuk mengakses form pemesanan
- [ ] Redirect ke login jika belum login + pesan "Silakan login terlebih dahulu"

## 📝 Status Pemesanan

- `pending` - Pemesanan baru, menunggu pembayaran
- `active` - Pemesanan sudah terkonfirmasi/dibayar
- `completed` - Sewa sudah selesai
- `cancelled` - Sewa dibatalkan

## 🔄 Next Steps

1. ✅ Form pemesanan - DONE
2. ⏳ Halaman dashboard menampilkan pemesanan user
3. ⏳ Integrasi dengan sistem pembayaran
4. ⏳ Notifikasi email setelah pemesanan
5. ⏳ Admin review dan konfirmasi pemesanan
6. ⏳ Receipt dan invoice PDF

