<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $fillable = [
        'user_id',
        'tanggal_pesan',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_harga',
        'status'
    ];

    protected $casts = [
        'tanggal_pesan' => 'datetime',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function details()
    {
        return $this->hasMany(DetailPemesanan::class, 'pemesanan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
