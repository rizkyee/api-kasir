<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    public $timestamps = false;

    protected $fillable = [
        'nama_produk',
        'id_kategori',
        'harga',
        'stok',
        'deskripsi',
        'gambar_produk'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
