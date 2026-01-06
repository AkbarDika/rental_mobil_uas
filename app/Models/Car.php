<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'mobil'; // ⬅️ PENTING

    protected $fillable = [
        'kategori_id',
        'merk',
        'model',
        'tahun',
        'nomor_plat',
        'harga_sewa',
        'status',
        'foto'
    ];
}


