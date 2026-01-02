<?php

namespace App\Services;

use App\Models\Transaksi;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    public function summary()
    {
        return [
            'total_transaksi' => Transaksi::count(),
            'transaksi_hari_ini' => Transaksi::whereDate('tanggal', today())->count(),
            'transaksi_lunas' => Transaksi::where('status', 'Lunas')->count(),
            'total_kategori' => Kategori::count(),
        ];
    }

    public function weeklyChart()
    {
        $lastDate = Transaksi::max('tanggal');

        if (!$lastDate) {
            return [];
        }

        return Transaksi::select(
            DB::raw('DATE(tanggal) as tanggal'),
            DB::raw('SUM(total_harga) as total')
        )
            ->whereBetween('tanggal', [
                \Carbon\Carbon::parse($lastDate)->subDays(6),
                $lastDate
            ])
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy('tanggal')
            ->get();
    }

    public function paymentMethods()
    {
        return Transaksi::select('id_metode', DB::raw('COUNT(*) as total'))
            ->with('metode')
            ->groupBy('id_metode')
            ->get()
            ->map(function ($item) {
                return [
                    'metode' => $item->metode->nama_metode ?? 'Tidak Diketahui',
                    'total'  => $item->total
                ];
            });
    }
}
