<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = ['user_id', 'paket', 'jumlah_sepatu', 'layanan_tambahan', 'total_biaya', 'status'];

    // Otomatis mengubah JSON menjadi Array saat dipanggil
    protected $casts = [
        'layanan_tambahan' => 'array'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
