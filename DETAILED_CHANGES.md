# 🔧 DETAILED CHANGES - Line by Line

## 1. Model: Pemesanan.php

### BEFORE ❌
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $fillable = [
        'user_id',
        'car_id',                  ❌ NOT IN DB
        'tanggal_sewa',            ❌ WRONG NAME
        'tanggal_kembali',         ❌ WRONG NAME
        'lokasi_pickup',           ❌ NOT IN DB
        'lokasi_kembali',          ❌ NOT IN DB
        'total_harga',
        'status',
        'catatan',                 ❌ NOT IN DB
    ];

    protected $casts = [
        'tanggal_sewa' => 'date',
        'tanggal_kembali' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Pemesanan milik satu User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: Pemesanan untuk satu Mobil
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car_id');  ❌ WRONG
    }
}
```

### AFTER ✅
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;  ✅ ADDED

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $fillable = [
        'user_id',
        'tanggal_pesan',           ✅ CORRECT
        'tanggal_mulai',           ✅ CORRECT
        'tanggal_selesai',         ✅ CORRECT
        'total_harga',
        'status',
    ];

    protected $casts = [
        'tanggal_pesan' => 'date',      ✅ CORRECT
        'tanggal_mulai' => 'date',      ✅ CORRECT
        'tanggal_selesai' => 'date',    ✅ CORRECT
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Pemesanan milik satu User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: Pemesanan memiliki banyak Detail Pemesanan
     */
    public function detailPemesanan(): HasMany  ✅ NEW
    {
        return $this->hasMany(DetailPemesanan::class, 'pemesanan_id');
    }

    /**
     * Relationship: Akses ke mobil melalui detail_pemesanan
     */
    public function mobil()  ✅ NEW
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
}
```

---

## 2. Model: DetailPemesanan.php (NEW FILE) ✅

### Created
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPemesanan extends Model  ✅ NEW CLASS
{
    protected $table = 'detail_pemesanan';

    protected $fillable = [
        'pemesanan_id',
        'mobil_id',            ✅ CAR ID HERE!
        'lama_sewa',
        'harga_per_hari',
        'subtotal',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Detail pemesanan milik satu Pemesanan
     */
    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    /**
     * Relationship: Detail pemesanan untuk satu Mobil
     */
    public function mobil(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'mobil_id');
    }
}
```

---

## 3. Controller: RentalController.php

### Imports CHANGED
```php
// BEFORE ❌
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// AFTER ✅
use App\Models\Car;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;  ✅ ADDED
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;        ✅ ADDED (for transaction)
```

### Method: create() - UNCHANGED ✅
```php
// Same as before - no changes needed
```

### Method: store() - COMPLETELY REWRITTEN ✅

#### BEFORE ❌
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'car_id' => 'required|exists:mobil,id',           ❌ WRONG NAME
        'tanggal_sewa' => 'required|date|after:today',    ❌ WRONG NAME
        'tanggal_kembali' => 'required|date|after:tanggal_sewa',  ❌ WRONG NAME
        'lokasi_pickup' => 'required|string|max:255',     ❌ NOT IN DB
        'lokasi_kembali' => 'required|string|max:255',    ❌ NOT IN DB
        'catatan' => 'nullable|string|max:500',           ❌ NOT IN DB
    ]);

    $tanggal_sewa = \Carbon\Carbon::parse($request->tanggal_sewa);
    $tanggal_kembali = \Carbon\Carbon::parse($request->tanggal_kembali);
    $durasi = $tanggal_kembali->diffInDays($tanggal_sewa);

    $car = Car::find($request->car_id);
    $total_harga = $durasi * $car->harga_sewa;

    // ❌ Single table insert - WRONG!
    $pemesanan = Auth::user()->pemesanan()->create([
        'car_id' => $request->car_id,
        'tanggal_sewa' => $request->tanggal_sewa,
        'tanggal_kembali' => $request->tanggal_kembali,
        'lokasi_pickup' => $request->lokasi_pickup,
        'lokasi_kembali' => $request->lokasi_kembali,
        'total_harga' => $total_harga,
        'status' => 'pending',
        'catatan' => $request->catatan,
    ]);

    return redirect('/dashboard')->with('success', '...');
}
```

#### AFTER ✅
```php
public function store(Request $request)
{
    // ✅ CORRECT validation
    $validated = $request->validate([
        'mobil_id' => 'required|exists:mobil,id',
        'tanggal_mulai' => 'required|date|after:today',
        'tanggal_selesai' => 'required|date|after:tanggal_mulai',
    ]);

    // ✅ Correct variable names
    $tanggal_mulai = \Carbon\Carbon::parse($request->tanggal_mulai);
    $tanggal_selesai = \Carbon\Carbon::parse($request->tanggal_selesai);
    $lama_sewa = $tanggal_selesai->diffInDays($tanggal_mulai);

    // Get car
    $car = Car::find($request->mobil_id);
    $harga_per_hari = $car->harga_sewa;
    $subtotal = $lama_sewa * $harga_per_hari;

    // ✅ 2-Table Transaction!
    $pemesanan = DB::transaction(function () use ($request, $tanggal_mulai, $lama_sewa, $harga_per_hari, $subtotal) {
        // Step 1: Create Pemesanan (Master)
        $pemesanan = Pemesanan::create([
            'user_id' => Auth::id(),
            'tanggal_pesan' => now()->toDateString(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'total_harga' => $subtotal,
            'status' => 'pending',
        ]);

        // Step 2: Create Detail Pemesanan with mobil_id
        DetailPemesanan::create([
            'pemesanan_id' => $pemesanan->id,
            'mobil_id' => $request->mobil_id,      ✅ CAR ID HERE!
            'lama_sewa' => $lama_sewa,
            'harga_per_hari' => $harga_per_hari,
            'subtotal' => $subtotal,
        ]);

        return $pemesanan;
    });

    return redirect('/dashboard')->with('success', 'Pemesanan berhasil dibuat! ID Pemesanan: #' . $pemesanan->id);
}
```

### Methods: Removed ✅
```php
// ❌ Removed (not needed at this stage):
// - show($pemesananId)
// - edit($pemesananId)
// - update(Request $request, $pemesananId)
// - cancel($pemesananId)
```

---

## 4. View: rental/create.blade.php

### Form Fields CHANGED

#### BEFORE ❌
```blade
<input type="hidden" name="car_id" value="{{ $car->id }}">

<label for="tanggal_sewa" class="form-label fw-bold">
    <i class="bi bi-calendar-plus"></i> Tanggal Sewa
</label>
<input type="date" id="tanggal_sewa" name="tanggal_sewa" ... />

<label for="tanggal_kembali" class="form-label fw-bold">
    <i class="bi bi-calendar-minus"></i> Tanggal Kembali
</label>
<input type="date" id="tanggal_kembali" name="tanggal_kembali" ... />

<label for="lokasi_pickup" class="form-label fw-bold">
    <i class="bi bi-geo-alt"></i> Lokasi Pickup
</label>
<select id="lokasi_pickup" name="lokasi_pickup" ... />

<label for="lokasi_kembali" class="form-label fw-bold">
    <i class="bi bi-pin-map"></i> Lokasi Kembali
</label>
<select id="lokasi_kembali" name="lokasi_kembali" ... />

<label for="catatan" class="form-label fw-bold">
    <i class="bi bi-chat-left-text"></i> Catatan Tambahan
</label>
<textarea id="catatan" name="catatan" ... />
```

#### AFTER ✅
```blade
<input type="hidden" name="mobil_id" value="{{ $car->id }}">  ✅ RENAMED

<label for="tanggal_mulai" class="form-label fw-bold">
    <i class="bi bi-calendar-plus"></i> Tanggal Mulai Sewa      ✅ RENAMED
</label>
<input type="date" id="tanggal_mulai" name="tanggal_mulai" ... />

<label for="tanggal_selesai" class="form-label fw-bold">
    <i class="bi bi-calendar-minus"></i> Tanggal Selesai Sewa   ✅ RENAMED
</label>
<input type="date" id="tanggal_selesai" name="tanggal_selesai" ... />

<!-- ✅ REMOVED lokasi_pickup, lokasi_kembali, catatan -->
```

### JavaScript CHANGED
```javascript
// BEFORE ❌
const tanggalSewaInput = document.getElementById('tanggal_sewa');
const tanggalKembaliInput = document.getElementById('tanggal_kembali');

function hitungTotal() {
    const tanggalSewa = new Date(tanggalSewaInput.value);
    const tanggalKembali = new Date(tanggalKembaliInput.value);
    
    if (tanggalSewaInput.value && tanggalKembaliInput.value && tanggalKembali > tanggalSewa) {
        const selisihHari = Math.ceil((tanggalKembali - tanggalSewa) / ...);
        ...
    }
}

tanggalSewaInput.addEventListener('change', hitungTotal);
tanggalKembaliInput.addEventListener('change', hitungTotal);
tanggalSewaInput.setAttribute('min', today);
tanggalKembaliInput.setAttribute('min', today);

// AFTER ✅
const tanggalMulaiInput = document.getElementById('tanggal_mulai');      ✅ RENAMED
const tanggalSelesaiInput = document.getElementById('tanggal_selesai');  ✅ RENAMED

function hitungTotal() {
    const tanggalMulai = new Date(tanggalMulaiInput.value);              ✅ RENAMED
    const tanggalSelesai = new Date(tanggalSelesaiInput.value);          ✅ RENAMED
    
    if (tanggalMulaiInput.value && tanggalSelesaiInput.value && tanggalSelesai > tanggalMulai) {
        const selisihHari = Math.ceil((tanggalSelesai - tanggalMulai) / ...);
        ...
    }
}

tanggalMulaiInput.addEventListener('change', hitungTotal);              ✅ RENAMED
tanggalSelesaiInput.addEventListener('change', hitungTotal);            ✅ RENAMED
tanggalMulaiInput.setAttribute('min', today);                           ✅ RENAMED
tanggalSelesaiInput.setAttribute('min', today);                         ✅ RENAMED
```

---

## 5. Database: Migrations

### create_pemesanan_table.php - VERIFIED ✅
```php
// Already correct structure:
✅ id, user_id, tanggal_pesan, tanggal_mulai, tanggal_selesai
✅ total_harga, status, timestamps
❌ NEVER had car_id, lokasi_pickup, lokasi_kembali, catatan
```

### create_detail_pemesanan_table.php - VERIFIED ✅
```php
// Already correct structure:
✅ id, pemesanan_id, mobil_id, lama_sewa, harga_per_hari, subtotal, timestamps
✅ mobil_id FK to mobil(id)
```

---

## Summary of Changes

| Component | Change | Type |
|-----------|--------|------|
| Pemesanan Model | Removed car_id, lokasi_*, catatan | FIXED |
| Pemesanan Model | Added detailPemesanan relationship | ADDED |
| Pemesanan Model | Renamed tanggal_sewa→mulai, kembali→selesai | FIXED |
| DetailPemesanan Model | Created new model | CREATED |
| DetailPemesanan Model | Added pemesanan, mobil relationships | CREATED |
| RentalController | Updated store() with 2-table transaction | FIXED |
| RentalController | Changed validation fields | FIXED |
| rental/create.blade.php | Renamed form fields | FIXED |
| rental/create.blade.php | Removed lokasi_*, catatan fields | FIXED |
| rental/create.blade.php | Updated JavaScript variables | FIXED |
| Migration files | No changes needed | OK |

---

**Status:** ✅ ALL CHANGES COMPLETE
**Ready for:** ✅ Production Testing
**Last Updated:** January 7, 2026

