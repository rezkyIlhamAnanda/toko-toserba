<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use HasFactory;

    // Jika nama tabel tidak mengikuti konvensi, tentukan di sini (opsional)
    protected $table = 'banners';

    // Tentukan field mana yang dapat diisi massal
    protected $fillable = [
        'gambar_banner', // nama kolom di tabel
        // tambahkan kolom lain yang relevan
    ];

    // Jika Anda memiliki timestamp, Anda dapat mengatur ini
    public $timestamps = true; // default true, jika Anda tidak menggunakan created_at dan updated_at, set ke false
}
