<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reservasi;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'id_reservasi',
        'tgl_bayar',
        'jumlah',
        'status_bayar',
        'metode_bayar',
        'catatan',
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi');
    }
}