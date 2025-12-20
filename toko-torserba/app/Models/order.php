<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'pelanggan_id',       // ✅ diganti dari user_id
        'subtotal',
        'shipping_cost',
        'total_amount',
        'shipping_address',
        'shipping_status',
        'payment_status',
        'payment_method',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    // ✅ Relasi ke pelanggan (bukan admin)
    public function pelanggan()
    {
        return $this->belongsTo(UserPelanggan::class, 'pelanggan_id');
    }

    // (Opsional) Relasi ke admin jika dibutuhkan
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'user_id', 'pelanggan_id');
    }
}
