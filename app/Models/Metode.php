<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metode extends Model
{

    protected $table = 'metode';
    protected $primaryKey = 'id_metode';
    public $timestamps = false;

    protected $fillable = [
        'nama_metode'
    ];
}
