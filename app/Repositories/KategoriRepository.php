<?php

namespace App\Repositories;

use App\Models\Kategori;

class KategoriRepository
{
    public function getAll()
    {
        return Kategori::orderBy('id_kategori', 'DESC')->get();
    }

    public function findById($id)
    {
        return Kategori::find($id);
    }

    public function create(array $data)
    {
        $nextId = (Kategori::max('id_kategori') ?? 0) + 1;

        $data['id_kategori'] = $nextId;

        return Kategori::create($data);
    }


    public function update(Kategori $kategori, array $data)
    {
        $kategori->update($data);
        return $kategori;
    }

    public function delete(Kategori $kategori)
    {
        return $kategori->delete();
    }
}
