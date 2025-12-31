<?php

namespace App\Models;

use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Metode;
use App\Models\DetailTransaksi;
use App\Models\Produk;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
   protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'no_invoice',
        'tanggal',
        'id_pelanggan',
        'id_user',
        'total_harga',
        'status',
        'id_metode'
    ];

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function metode()
    {
        return $this->belongsTo(Metode::class, 'id_metode', 'id_metode');
    }
}
