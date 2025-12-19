<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi';

    protected $fillable = [
        'id_penyewa',
        'id_user',
        'tgl_checkin',
        'tgl_checkout',
        'jumlah_tamu',
        'status_reservasi',
        'total_harga',
        'dp',
        'catatan',
    ];

    public function kamar()
    {
        return $this->belongsToMany(
            Kamar::class,
            'reservasi_kamar',
            'id_reservasi',
            'id_kamar'
        )->withPivot('harga_per_malam');
    }

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'id_penyewa', 'id_penyewa');
    }
}
