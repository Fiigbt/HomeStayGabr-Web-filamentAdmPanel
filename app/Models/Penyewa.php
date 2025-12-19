<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    protected $table = 'penyewa';
    protected $primaryKey = 'id_penyewa'; // 🔥 WAJIB

    protected $fillable = [
        'nama_penyewa',
        'tgl_lahir',
        'umur',
        'jk',
        'no_tlp',
        'email',
    ];

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'id_penyewa', 'id_penyewa');
    }
}
