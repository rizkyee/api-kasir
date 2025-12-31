<?php

namespace App\Repositories;

use App\Models\Pelanggan;

class PelangganRepository
{
    public function all()
    {
        return Pelanggan::all();
    }

    public function findById($id)
    {
        return Pelanggan::find($id);
    }
}
