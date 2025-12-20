<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pelanggan extends Authenticatable
{
    use HasFactory;

    protected $table = 'pelanggans';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'alamat',
    ];

    protected $hidden = [
        'password',
    ];

    /* ================= RELATION ================= */

    public function orders()
    {
        return $this->hasMany(Order::class, 'pelanggan_id');
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'user_id');
    }
}
