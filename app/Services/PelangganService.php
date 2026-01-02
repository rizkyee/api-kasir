<?php

namespace App\Services;

use App\Repositories\PelangganRepository;

class PelangganService
{
    protected $repo;

    public function __construct(PelangganRepository $repo)
    {
        $this->repo = $repo;
    }

    public function listPelanggan()
    {
        return $this->repo->all();
    }

    public function detailPelanggan($id)
    {
        return $this->repo->findById($id);
    }
    
    public function tambahPelanggan($data)
    {
        return $this->repo->create($data);
    }
}
