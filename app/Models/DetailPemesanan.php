<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    protected $table = 'detail_pemesanan';

    protected $fillable = [
        'pemesanan_id',
        'mobil_id',
        'harga',
        'lama_sewa'
    ];

    public function mobil()
    {
        return $this->belongsTo(Car::class, 'mobil_id');
    }
}
