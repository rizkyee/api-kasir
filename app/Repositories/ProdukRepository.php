<?php

namespace App\Repositories;

use App\Models\Produk;

class ProdukRepository
{
    public function getAll()
    {
        return Produk::with('kategori')
            ->orderBy('id_produk', 'DESC')
            ->get();
    }

    public function findById($id)
    {
        return Produk::with('kategori')->find($id);
    }

    public function create(array $data)
    {
        return Produk::create($data);
    }

    public function update(Produk $produk, array $data)
    {
        $produk->update($data);
        return $produk;
    }

    public function delete(Produk $produk)
    {
        return $produk->delete();
    }
}
