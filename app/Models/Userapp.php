<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAdmin extends Model
{
    protected $table = 'user_app';
    protected $primaryKey = 'id_user';
    public $timestamps = true;

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'role',
        'tgl_lahir',
        'jk',
        'no_tlp',
    ];

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'id_user');
    }

}
