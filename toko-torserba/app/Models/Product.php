<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $fillable = [
        'nama_produk',
        'Harga',
        'stok',
        'image',
    ];

    /* ================= RELATION ================= */

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'produk_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'produk_id');
    }
}
