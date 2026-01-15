<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';

    protected $primaryKey = 'id_pengembalian';

    protected $fillable = [
        'pemesanan_id',
        'tanggal_kembali',
        'kondisi_mobil',
        'catatan',
        'status_pengembalian'
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    
}
