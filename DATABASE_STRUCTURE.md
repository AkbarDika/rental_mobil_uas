# 📋 Database Structure - Pemesanan & Detail Pemesanan

## 📊 Tabel Pemesanan (Master)

```sql
CREATE TABLE pemesanan (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    tanggal_pesan DATE NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    total_harga DECIMAL(14,2) NOT NULL DEFAULT 0,
    status ENUM('pending', 'disetujui', 'ditolak', 'selesai') DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Kolom-Kolom:
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | BIGINT | Primary Key |
| user_id | BIGINT | FK ke users - siapa yang memesan |
| tanggal_pesan | DATE | Tanggal pemesanan dibuat |
| tanggal_mulai | DATE | Tanggal mulai sewa |
| tanggal_selesai | DATE | Tanggal akhir sewa |
| total_harga | DECIMAL(14,2) | Total harga untuk semua detail |
| status | ENUM | pending/disetujui/ditolak/selesai |
| created_at | TIMESTAMP | Auto-filled by Laravel |
| updated_at | TIMESTAMP | Auto-filled by Laravel |

---

## 📋 Tabel Detail Pemesanan (Detail)

```sql
CREATE TABLE detail_pemesanan (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    pemesanan_id BIGINT NOT NULL,
    mobil_id BIGINT NOT NULL,
    lama_sewa INT NOT NULL,
    harga_per_hari DECIMAL(12,2) NOT NULL,
    subtotal DECIMAL(14,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (pemesanan_id) REFERENCES pemesanan(id) ON DELETE CASCADE,
    FOREIGN KEY (mobil_id) REFERENCES mobil(id) ON DELETE CASCADE
);
```

### Kolom-Kolom:
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | BIGINT | Primary Key |
| pemesanan_id | BIGINT | FK ke pemesanan - linking ke master |
| mobil_id | BIGINT | FK ke mobil - mobil yang dipesan ✅ |
| lama_sewa | INT | Durasi sewa dalam hari |
| harga_per_hari | DECIMAL(12,2) | Harga per hari mobil |
| subtotal | DECIMAL(14,2) | lama_sewa × harga_per_hari |
| created_at | TIMESTAMP | Auto-filled by Laravel |
| updated_at | TIMESTAMP | Auto-filled by Laravel |

---

## 🔗 Relationships

### User → Pemesanan (1:Many)
```
User (1) ──── (Many) Pemesanan
  id                  user_id
```

### Pemesanan → Detail Pemesanan (1:Many)
```
Pemesanan (1) ──── (Many) Detail Pemesanan
  id                      pemesanan_id
```

### Detail Pemesanan → Mobil (Many:1)
```
Detail Pemesanan (Many) ──── (1) Mobil
  mobil_id                        id
```

### Traversal: Pemesanan → Mobil (via Detail)
```
Pemesanan (1) ──── (Many) Detail Pemesanan (Many) ──── (1) Mobil
  id                      pemesanan_id              mobil_id
```

---

## 📝 Model Relationships (Eloquent)

### User Model
```php
public function pemesanan(): HasMany
{
    return $this->hasMany(Pemesanan::class, 'user_id');
}
```

### Pemesanan Model
```php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}

public function detailPemesanan(): HasMany
{
    return $this->hasMany(DetailPemesanan::class, 'pemesanan_id');
}

public function mobil() // HasManyThrough
{
    return $this->hasManyThrough(
        Car::class,
        DetailPemesanan::class,
        'pemesanan_id',
        'id',
        'id',
        'mobil_id'
    );
}
```

### DetailPemesanan Model
```php
public function pemesanan(): BelongsTo
{
    return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
}

public function mobil(): BelongsTo
{
    return $this->belongsTo(Car::class, 'mobil_id');
}
```

---

## 💾 Insert Process (2-Step Transaction)

### Request Form
```
mobil_id: 2
tanggal_mulai: 2026-01-08
tanggal_selesai: 2026-01-10
```

### Step 1: Create Pemesanan (Master)
```php
$pemesanan = Pemesanan::create([
    'user_id' => Auth::id(),          // 1
    'tanggal_pesan' => now(),         // 2026-01-07
    'tanggal_mulai' => '2026-01-08',
    'tanggal_selesai' => '2026-01-10',
    'total_harga' => 600000,          // 2 hari × 300000
    'status' => 'pending',
]);
// ✅ Created: pemesanan with ID 1
```

### Step 2: Create Detail Pemesanan (Detail)
```php
DetailPemesanan::create([
    'pemesanan_id' => 1,              // From step 1
    'mobil_id' => 2,                  // ✅ Mobil ID di sini!
    'lama_sewa' => 2,                 // Calculate from dates
    'harga_per_hari' => 300000,       // From Car model
    'subtotal' => 600000,             // 2 × 300000
]);
// ✅ Created: detail_pemesanan with pemesanan_id=1, mobil_id=2
```

### Result Database State
```
pemesanan (id=1):
┌─────────┬───────────┬──────────────┬─────────────┬──────────────┬───────────┬────────┐
│ id      │ user_id   │ tanggal_pesan│ tanggal_mul │ tanggal_seles│total_harga│ status │
├─────────┼───────────┼──────────────┼─────────────┼──────────────┼───────────┼────────┤
│ 1       │ 1         │ 2026-01-07   │ 2026-01-08  │ 2026-01-10   │ 600000    │pending │
└─────────┴───────────┴──────────────┴─────────────┴──────────────┴───────────┴────────┘

detail_pemesanan (id=1):
┌─────────┬──────────────────┬───────────┬──────────────┬─────────────┬───────────┐
│ id      │ pemesanan_id     │ mobil_id  │ lama_sewa    │ harga_pehari│ subtotal  │
├─────────┼──────────────────┼───────────┼──────────────┼─────────────┼───────────┤
│ 1       │ 1 (FK pemesanan) │ 2 (FK mbl)│ 2            │ 300000      │ 600000    │
└─────────┴──────────────────┴───────────┴──────────────┴─────────────┴───────────┘
```

---

## 🔍 Querying Examples

### Get pemesanan with mobil details
```php
$pemesanan = Pemesanan::with('detailPemesanan.mobil')->find(1);

// Access data
$pemesanan->id;                              // 1
$pemesanan->user->name;                      // User name
$pemesanan->total_harga;                     // 600000

// Via relationship
foreach($pemesanan->detailPemesanan as $detail) {
    $detail->mobil->merk;                    // Honda
    $detail->mobil->model;                   // Jazz
    $detail->lama_sewa;                      // 2
    $detail->harga_per_hari;                 // 300000
    $detail->subtotal;                       // 600000
}
```

### Get semua mobil yang dipesan user
```php
$user = Auth::user();
$pemesananList = $user->pemesanan()->with('detailPemesanan.mobil')->get();

foreach($pemesananList as $pemesanan) {
    foreach($pemesanan->detailPemesanan as $detail) {
        echo $detail->mobil->merk . " - " . $detail->subtotal;
    }
}
```

---

## ✅ Migration Files

### create_pemesanan_table.php
```
Location: database/migrations/2026_01_06_125037_create_pemesanan_table.php
Status: ✅ Sesuai dengan struktur database
```

### create_detail_pemesanan_table.php
```
Location: database/migrations/2026_01_06_125100_create_detail_pemesanan_table.php
Status: ✅ Sesuai dengan struktur database
```

---

## 🎯 Form Input Fields

```
Form: rental/create.blade.php

Input:
├── mobil_id (hidden)          ← Dari URL parameter {carId}
├── tanggal_mulai (date)       ← Date picker
├── tanggal_selesai (date)     ← Date picker
└── [Submit]

No longer needed:
├── lokasi_pickup              ❌ Removed (not in pemesanan/detail)
├── lokasi_kembali             ❌ Removed (not in pemesanan/detail)
└── catatan                    ❌ Removed (not in pemesanan/detail)
```

---

## 🔧 Controller Logic (RentalController@store)

```php
public function store(Request $request)
{
    // 1. Validate input
    $validated = $request->validate([
        'mobil_id' => 'required|exists:mobil,id',
        'tanggal_mulai' => 'required|date|after:today',
        'tanggal_selesai' => 'required|date|after:tanggal_mulai',
    ]);

    // 2. Calculate values
    $lama_sewa = $tanggal_selesai->diffInDays($tanggal_mulai);
    $harga_per_hari = $car->harga_sewa;
    $subtotal = $lama_sewa * $harga_per_hari;

    // 3. Transaction (atomic insert ke 2 tabel)
    $pemesanan = DB::transaction(function () {
        // Create master record
        $pemesanan = Pemesanan::create([
            'user_id' => Auth::id(),
            'tanggal_pesan' => now(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'total_harga' => $subtotal,
            'status' => 'pending',
        ]);

        // Create detail record
        DetailPemesanan::create([
            'pemesanan_id' => $pemesanan->id,
            'mobil_id' => $request->mobil_id,
            'lama_sewa' => $lama_sewa,
            'harga_per_hari' => $harga_per_hari,
            'subtotal' => $subtotal,
        ]);

        return $pemesanan;
    });

    return redirect('/dashboard')->with('success', '...');
}
```

---

## ❌ Removed Fields

Tidak lagi ada di form pemesanan:
- `lokasi_pickup` - Bisa ditambah di masa depan sebagai separate table
- `lokasi_kembali` - Bisa ditambah di masa depan sebagai separate table  
- `catatan` - Bisa ditambah di masa depan ke pemesanan table

---

## 📌 Summary Perbedaan

| Aspek | Sebelum (Error) | Sesudah (Benar) |
|-------|-----------------|-----------------|
| car_id | Di pemesanan ❌ | Di detail_pemesanan ✅ |
| lokasi_pickup | Di pemesanan | Dihapus (tidak di DB) |
| lokasi_kembali | Di pemesanan | Dihapus (tidak di DB) |
| catatan | Di pemesanan | Dihapus (tidak di DB) |
| Insert | Single table | 2 tables (transaction) |
| Model | Pemesanan saja | Pemesanan + DetailPemesanan |

---

**Status:** ✅ FIXED
**Last Updated:** January 7, 2026

