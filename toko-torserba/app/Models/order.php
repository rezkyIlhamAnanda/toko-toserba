<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'total',
        'lat',
        'long',
        'alamat',
        'ongkir',
        'status',
        'status_pembayaran',
        'payment_method',
    ];

    /* ================= RELATION ================= */

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function financialTransaction()
    {
        return $this->hasOne(FinancialTransaction::class, 'order_id');
    }
}
