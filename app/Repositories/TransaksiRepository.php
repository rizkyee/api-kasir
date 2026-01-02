<?php

namespace App\Repositories;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;

class TransaksiRepository
{
    public function paginate($perPage = 10)
    {
        return Transaksi::with(['pelanggan', 'metode'])
            ->orderByDesc('tanggal')
            ->paginate($perPage);
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

    public function filterPaginate(array $filters, $perPage = 10)
    {
        $query = Transaksi::with(['pelanggan', 'metode', 'user']);

        if (!empty($filters['start_date']) && empty($filters['end_date'])) {
            $query->whereDate('tanggal', $filters['start_date']);
        } elseif (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereDate('tanggal', '>=', $filters['start_date'])
                ->whereDate('tanggal', '<=', $filters['end_date']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['id_metode'])) {
            $query->where('id_metode', $filters['id_metode']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('no_invoice', 'like', '%' . $filters['search'] . '%')
                    ->orWhereHas('pelanggan', function ($q2) use ($filters) {
                        $q2->where('nama_pelanggan', 'like', '%' . $filters['search'] . '%');
                    });
            });
        }

        $query->orderByDesc('tanggal');

        return $query->paginate($perPage);
    }
}
