<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasUser extends Model
{
    protected $table = 'aktivitas_user';
    protected $primaryKey = 'id_aktivitas';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'aksi',
        'modul',
        'deskripsi',
        'ip_address',
        'user_agent',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
