<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FotoKamar extends Model
{
    use HasFactory;

    protected $table = 'foto_kamar';

    protected $fillable = [
        'id_kamar',
        'url',
        'caption',
        'is_cover',
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }
}
