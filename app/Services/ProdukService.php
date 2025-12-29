<?php

namespace App\Services;

use App\Repositories\ProdukRepository;
use App\Repositories\KategoriRepository;

class ProdukService
{
    public function __construct(
        protected ProdukRepository $repo,
        protected KategoriRepository $kategoriRepo
    ) {}

    public function all()
    {
        return $this->repo->getAll();
    }

    public function find($id)
    {
        return $this->repo->findById($id);
    }

    public function create(array $data)
    {
        // cek kategori harus ada
        if (! $this->kategoriRepo->findById($data['id_kategori'])) {
            return null;
        }

        return $this->repo->create($data);
    }

    public function update($id, array $data)
    {
        $produk = $this->repo->findById($id);

        if (! $produk) return null;

        // cek kategori baru (kalau diubah)
        if (isset($data['id_kategori'])) {
            if (! $this->kategoriRepo->findById($data['id_kategori'])) {
                return false;
            }
        }

        return $this->repo->update($produk, $data);
    }

    public function delete($id)
    {
        $produk = $this->repo->findById($id);

        if (! $produk) return false;

        return $this->repo->delete($produk);
    }
}
