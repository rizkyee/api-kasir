<?php

namespace App\Models;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail';
    public $timestamps = false;

    protected $fillable = [
        'id_transaksi','id_produk','id_kategori',
        'produk','jumlah','harga_satuan','total'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class,'id_produk','id_produk');
    }
}

