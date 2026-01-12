<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role_id',
        'alamat',
        'no_hp',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function pemesanan(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'user_id');
    }
}
