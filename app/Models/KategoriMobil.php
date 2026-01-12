<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriMobil extends Model
{
    protected $table = 'kategori_mobil';

    protected $fillable = ['nama_kategori', 'deskripsi'];

    // RELASI: Kategori → Banyak Mobil
    public function cars()
    {
        return $this->hasMany(Car::class, 'kategori_id');
    }
}
