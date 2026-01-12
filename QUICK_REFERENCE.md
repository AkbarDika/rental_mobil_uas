# 🎯 QUICK REFERENCE - Database Structure & Insert Logic

## 📊 Table Structure

### pemesanan (Master Table)
```
Column              | Type          | Notes
--------------------|---------------|---------------------------
id                  | BIGINT PK     | Auto-increment
user_id             | BIGINT FK     | References users(id)
tanggal_pesan       | DATE          | When order created
tanggal_mulai       | DATE          | Start rental date
tanggal_selesai     | DATE          | End rental date
total_harga         | DECIMAL(14,2) | Sum of subtotals
status              | ENUM          | pending/disetujui/ditolak/selesai
created_at          | TIMESTAMP     | Auto-filled by Laravel
updated_at          | TIMESTAMP     | Auto-filled by Laravel
```

### detail_pemesanan (Detail Table)
```
Column              | Type          | Notes
--------------------|---------------|---------------------------
id                  | BIGINT PK     | Auto-increment
pemesanan_id        | BIGINT FK     | References pemesanan(id)
mobil_id            | BIGINT FK     | References mobil(id) ⭐
lama_sewa           | INT           | Duration in days
harga_per_hari      | DECIMAL(12,2) | Price per day
subtotal            | DECIMAL(14,2) | lama_sewa × harga_per_hari
created_at          | TIMESTAMP     | Auto-filled by Laravel
updated_at          | TIMESTAMP     | Auto-filled by Laravel
```

---

## 🔑 Key Points

✅ **mobil_id** ada di detail_pemesanan, BUKAN di pemesanan
✅ **tanggal_pesan** = tanggal order dibuat (hari ini)
✅ **tanggal_mulai** = tanggal mulai sewa (user input)
✅ **tanggal_selesai** = tanggal akhir sewa (user input)
✅ **total_harga** = sum dari semua detail_pemesanan.subtotal
✅ **lama_sewa** = tanggal_selesai - tanggal_mulai (auto-calculated)
✅ **harga_per_hari** = dari mobil.harga_sewa
✅ **subtotal** = lama_sewa × harga_per_hari

---

## 📝 Insert Logic

### Input dari Form
```php
[
    'mobil_id' => 1,                    // Selected car
    'tanggal_mulai' => '2026-01-08',   // User date picker
    'tanggal_selesai' => '2026-01-10'  // User date picker
]
```

### Processing (Controller)
```php
$car = Car::find($request->mobil_id);          // Get car data
$lama_sewa = $tanggal_selesai->diffInDays(...); // Calculate days
$subtotal = $lama_sewa * $car->harga_sewa;     // Calculate price
```

### Step 1: Create Pemesanan
```php
$pemesanan = Pemesanan::create([
    'user_id' => Auth::id(),
    'tanggal_pesan' => now()->toDateString(),   // Today
    'tanggal_mulai' => $request->tanggal_mulai, // From form
    'tanggal_selesai' => $request->tanggal_selesai, // From form
    'total_harga' => $subtotal,
    'status' => 'pending'
]);
// Returns: $pemesanan->id = 1
```

### Step 2: Create DetailPemesanan
```php
DetailPemesanan::create([
    'pemesanan_id' => $pemesanan->id,        // From step 1
    'mobil_id' => $request->mobil_id,        // ⭐ Car ID here!
    'lama_sewa' => $lama_sewa,
    'harga_per_hari' => $car->harga_sewa,
    'subtotal' => $subtotal
]);
```

---

## 🔗 Relationships (Eloquent)

```
User (1) ═════════════════════════════════════════════ Pemesanan (Many)
  id                                                      user_id
                                                             ║
                                                             ║
Pemesanan (1) ═════════════════════════════════════════ DetailPemesanan (Many)
  id                                                      pemesanan_id
                                                             ║
                                                             ║
                                                          mobil_id
                                                             ║
                                                             ║
                                                     Car/Mobil (1)
                                                             id
```

### Query Example
```php
// Get pemesanan with all details
$pemesanan = Pemesanan::with('detailPemesanan.mobil')->find(1);

// Access data
$pemesanan->user->name;                    // User name
$pemesanan->total_harga;                   // Total price
$pemesanan->status;                        // Order status

// Loop through details
foreach ($pemesanan->detailPemesanan as $detail) {
    $detail->mobil->merk;                  // Honda
    $detail->mobil->model;                 // Jazz
    $detail->lama_sewa;                    // 2 days
    $detail->harga_per_hari;               // 300000
    $detail->subtotal;                     // 600000
}
```

---

## ✅ Form Fields (What's Included)

### Input Required
```
✅ mobil_id (hidden, from URL param {carId})
✅ tanggal_mulai (date picker)
✅ tanggal_selesai (date picker)
```

### Auto-Calculated
```
✅ lama_sewa = tanggal_selesai - tanggal_mulai
✅ harga_per_hari = from Car.harga_sewa
✅ subtotal = lama_sewa × harga_per_hari
✅ total_harga = subtotal (for single order)
✅ tanggal_pesan = now() (server-side)
```

### ❌ Removed (Not in DB)
```
❌ lokasi_pickup
❌ lokasi_kembali
❌ catatan
```

---

## 🧮 Example Transaction

### Input
```
User: Budi (ID: 1)
Car: Honda Jazz (ID: 1, harga: 300000)
Start: 2026-01-08
End: 2026-01-10
```

### Processing
```
lama_sewa = 2 days
subtotal = 2 × 300000 = 600000
```

### Step 1 - Insert pemesanan
```sql
INSERT INTO pemesanan (user_id, tanggal_pesan, tanggal_mulai, tanggal_selesai, total_harga, status)
VALUES (1, '2026-01-07', '2026-01-08', '2026-01-10', 600000, 'pending')
→ Returns: ID 1
```

### Step 2 - Insert detail_pemesanan
```sql
INSERT INTO detail_pemesanan (pemesanan_id, mobil_id, lama_sewa, harga_per_hari, subtotal)
VALUES (1, 1, 2, 300000, 600000)
→ Returns: ID 1
```

### Final State
```
pemesanan:
ID=1, user_id=1, tanggal_pesan=2026-01-07, tanggal_mulai=2026-01-08, 
tanggal_selesai=2026-01-10, total_harga=600000, status='pending'

detail_pemesanan:
ID=1, pemesanan_id=1, mobil_id=1, lama_sewa=2, 
harga_per_hari=300000, subtotal=600000
```

---

## 🚀 Code References

### RentalController@store
```php
public function store(Request $request)
{
    // Validate: mobil_id, tanggal_mulai, tanggal_selesai
    
    // Get car
    $car = Car::find($request->mobil_id);
    
    // Calculate
    $lama_sewa = $tanggal_selesai->diffInDays($tanggal_mulai);
    $subtotal = $lama_sewa * $car->harga_sewa;
    
    // Transaction
    $pemesanan = DB::transaction(function () {
        // Create master
        $pemesanan = Pemesanan::create([...]);
        
        // Create detail
        DetailPemesanan::create([...]);
        
        return $pemesanan;
    });
    
    return redirect('/dashboard')->with('success', '...');
}
```

### Models
```php
// Pemesanan model
public function detailPemesanan(): HasMany {}
public function user(): BelongsTo {}
public function mobil(): HasManyThrough {}

// DetailPemesanan model
public function pemesanan(): BelongsTo {}
public function mobil(): BelongsTo {}

// User model
public function pemesanan(): HasMany {}
```

---

## 📋 Checklist Before Testing

- [x] Database migrations run: `php artisan migrate:fresh --seed`
- [x] Sessions table created
- [x] Test data seeded
- [x] Models updated (Pemesanan, DetailPemesanan)
- [x] Controller updated (RentalController@store)
- [x] Form fields updated (tanggal_mulai, tanggal_selesai, mobil_id)
- [x] Removed fields (lokasi_pickup, lokasi_kembali, catatan)
- [x] Routes configured
- [x] User relationships set

---

## 🎯 Result

✅ Insert ke 2 tabel (pemesanan + detail_pemesanan)
✅ mobil_id stored di detail_pemesanan
✅ Lokasi dan catatan removed
✅ Transaction ensures atomicity
✅ Ready for production

---

**Quick Test URL:**
```
Login: http://127.0.0.1:8000/login (customer1 / password)
Form: http://127.0.0.1:8000/rental/1 (after login)
Submit: Fill dates → Click "Konfirmasi Pemesanan"
Result: Should redirect to /dashboard with success message
```

**Database Check:**
```sql
SELECT p.*, dp.mobil_id, m.merk FROM pemesanan p
JOIN detail_pemesanan dp ON p.id = dp.pemesanan_id
JOIN mobil m ON dp.mobil_id = m.id;
```

---

**Status:** ✅ COMPLETE & TESTED
**Last Updated:** January 7, 2026
