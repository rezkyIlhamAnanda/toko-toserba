<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    // Nama tabel
    protected $table = 'keranjangs';

    // Kolom yang bisa diisi
    protected $fillable = [
        'user_id',
        'product_id',
        'jumlah',
        'harga',
    ];

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke user (opsional kalau ada login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
