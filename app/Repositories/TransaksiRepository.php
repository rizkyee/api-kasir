<?php

namespace App\Repositories;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;

class TransaksiRepository
{
    public function all()
    {
        return Transaksi::with(['pelanggan', 'metode'])->get();
    }

    public function findById($id)
    {
        return Transaksi::with([
            'pelanggan',
            'user',
            'metode',
            'detail.produk'
        ])->where('id_transaksi', $id)->first();
    }

    public function createTransaksi(array $data)
    {
        return Transaksi::create($data);
    }

    public function createDetail(array $data)
    {
        return DetailTransaksi::create($data);
    }

    public function findProduk($id)
    {
        return Produk::find($id);
    }

}
