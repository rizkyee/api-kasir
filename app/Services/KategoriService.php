<?php

namespace App\Services;

use App\Repositories\KategoriRepository;

class KategoriService
{
    public function __construct(protected KategoriRepository $repo) {}

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
        return $this->repo->create($data);
    }

    public function update($id, array $data)
    {
        $kategori = $this->repo->findById($id);

        if (! $kategori) return null;

        return $this->repo->update($kategori, $data);
    }

    public function delete($id)
    {
        $kategori = $this->repo->findById($id);

        if (! $kategori) return false;

        return $this->repo->delete($kategori);
    }
}
