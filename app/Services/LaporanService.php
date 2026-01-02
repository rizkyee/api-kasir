<?php

namespace App\Services;

use Shuchkin\SimpleXLSXGen;
use App\Models\Laporan;
use App\Models\Transaksi;
use Mpdf\Mpdf;
use App\Repositories\LaporanRepository;

class LaporanService
{
    public function __construct(
        protected LaporanRepository $repo
    ) {}
    public function getTransaksiByDate($start, $end, $metode = null, $status = null)
    {
        $query = Transaksi::with(['pelanggan', 'user', 'metode'])
            ->whereDate('tanggal', '>=', $start)
            ->whereDate('tanggal', '<=', $end);

        if ($metode) {
            $query->whereHas('metode', function ($q) use ($metode) {
                $q->where('nama_metode', $metode);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }

    public function saveLog($jenis, $keterangan, $userId)
    {
        return $this->repo->create([
            'jenis_laporan' => $jenis,
            'id_user'       => $userId,
            'keterangan'    => $keterangan
        ]);
    }
    public function getAllLaporan()
    {
        return $this->repo->all();
    }


    public function generateExcel($data)
    {
        $total = $data->sum('total_harga');

        $rows = [
            ['LAPORAN TRANSAKSI'],
            ['Jenis Laporan', request('jenis_laporan')],
            ['Keterangan', request('keterangan')],
            ['Total Transaksi', number_format($total, 0, ',', '.')],
            [],
            ['No', 'Invoice', 'Tanggal', 'Pelanggan', 'Total', 'Status']
        ];

        foreach ($data as $i => $trx) {
            $rows[] = [
                $i + 1,
                $trx->no_invoice,
                $trx->tanggal,
                optional($trx->pelanggan)->nama_pelanggan,
                $trx->total_harga,
                $trx->status
            ];
        }

        $xlsx = SimpleXLSXGen::fromArray($rows);
        $path = storage_path('app/public/laporan-transaksi.xlsx');
        $xlsx->saveAs($path);

        return $path;
    }


    public function generatePDF($data)
    {
        $total = $data->sum('total_harga');

        $html = "
    <h3>Laporan Transaksi</h3>
    <p><b>Jenis Laporan:</b> " . request('jenis_laporan') . "</p>
    <p><b>Keterangan:</b> " . request('keterangan') . "</p>
    <p><b>Total Transaksi:</b> " . number_format($total, 0, ',', '.') . "</p>

    <table border='1' width='100%' cellpadding='6'>
        <tr>
            <th>No</th>
            <th>Invoice</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Total</th>
            <th>Status</th>
        </tr>";

        foreach ($data as $i => $trx) {
            $html .= "
        <tr>
            <td>" . ($i + 1) . "</td>
            <td>{$trx->no_invoice}</td>
            <td>{$trx->tanggal}</td>
            <td>" . optional($trx->pelanggan)->nama_pelanggan . "</td>
            <td>{$trx->total_harga}</td>
            <td>{$trx->status}</td>
        </tr>";
        }

        $html .= "</table>";

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        $path = storage_path('app/public/laporan-transaksi.pdf');
        $mpdf->Output($path, 'F');

        return $path;
    }
}
