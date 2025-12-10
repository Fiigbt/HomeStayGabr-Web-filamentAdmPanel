<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'catatan'
    ];

    public function penyewa(): BelongsTo
    {
        return $this->belongsTo(Penyewa::class, 'id_penyewa', 'id_penyewa');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kamar(): HasMany
    {
        return $this->hasMany(ReservasiKamar::class, 'id_reservasi');
    }
}
