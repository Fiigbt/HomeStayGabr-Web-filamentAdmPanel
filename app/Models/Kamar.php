<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';

    protected $fillable = [
        'nomor_kamar',
        'lantai',
        'kapasitas',
        'harga_per_malam',
        'status_kamar',
        'deskripsi',
    ];

    public function reservasis()
    {
        return $this->belongsToMany(
            Reservasi::class,
            'reservasi_kamar',
            'id_kamar',
            'id_reservasi'
        )->withPivot('harga_per_malam');
    }
}
