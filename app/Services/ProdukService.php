<?php

namespace App\Services;

use App\Models\Produk;
use App\Repositories\ProdukRepository;
use App\Repositories\KategoriRepository;
use Illuminate\Support\Facades\Storage;

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

        $produk = Produk::find($id);

        if (! $produk) {
            return null;
        }


        if (isset($data['id_kategori'])) {
            if (! $this->kategoriRepo->findById($data['id_kategori'])) {
                return false;
            }
        }

        if (!empty($data['gambar_produk'])) {
            if ($produk->gambar_produk) {
                Storage::disk('public')->delete($produk->gambar_produk);
            }
        }

        $this->repo->update($produk, $data);

        $fresh = $produk->fresh('kategori');


        return $fresh;
    }





    public function delete($id)
    {
        $produk = $this->repo->findById($id);
        if (! $produk) return false;
    
        if ($produk->gambar_produk) {
            Storage::disk('public')->delete($produk->gambar_produk);
        }
    
        return $this->repo->delete($produk);
    }
}
