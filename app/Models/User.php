<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role_id',
    ];


    protected $hidden = ['password'];

    /**
     * Relationship: User memiliki banyak pemesanan
     */
    public function pemesanan(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'user_id');
    }
}
