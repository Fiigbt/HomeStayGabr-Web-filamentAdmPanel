<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservasiKamar extends Model
{
    protected $table = 'reservasi_kamar';
    public $timestamps = false;

    protected $fillable = [
        'id_reservasi',
        'id_kamar',
        'harga_per_malam'
    ];

    public function reservasi(): BelongsTo
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi');
    }

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }
}
