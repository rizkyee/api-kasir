<?php

namespace App\Repositories;

use App\Models\Laporan;

class LaporanRepository
{
    public function all()
    {
        return Laporan::with('user')
            ->orderBy('tanggal_cetak', 'desc')
            ->get();
    }

    public function create(array $data)
    {
        return Laporan::create($data);
    }
}
