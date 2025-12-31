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
        return Produk::with('kategori')
            ->where('id_produk', $id)
            ->first();
    }

    public function create(array $data)
    {
        return Produk::create($data)->load('kategori');
    }
    public function update(Produk $produk, array $data)
    {

        $produk->fill($data);


        $produk->save();


        return $produk->fresh('kategori');
    }


    public function delete(Produk $produk)
    {
        return $produk->delete();
    }
}
