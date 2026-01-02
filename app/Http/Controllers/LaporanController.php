<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LaporanService;

class LaporanController extends Controller
{
    public function __construct(
        protected LaporanService $service
    ) {}

    public function index()
    {
        $data = $this->service->getAllLaporan();

        return response()->json([
            'message' => 'Daftar laporan',
            'total'   => $data->count(),
            'data'    => $data
        ]);
    }

    public function cetak(Request $request)
    {
        $request->validate([
            'start_date'    => 'required|date',
            'end_date'      => 'required|date',
            'jenis_laporan' => 'required|string|max:50',
            'file_type'     => 'required|in:excel,pdf',
            'keterangan'    => 'nullable',
            'metode'        => 'nullable|string',
            'status'        => 'nullable|string'
        ]);

        $data = $this->service->getTransaksiByDate(
            $request->start_date,
            $request->end_date,
            $request->metode,
            $request->status
        );

        if ($data->count() === 0) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $userId = $request->user()->id_user;

        $this->service->saveLog(
            $request->jenis_laporan,
            $request->keterangan,
            $userId
        );

        if ($request->file_type === 'excel') {
            $file = $this->service->generateExcel($data);
            return response()->download($file, 'laporan-transaksi.xlsx');
        }

        $file = $this->service->generatePDF($data);
        return response()->download($file, 'laporan-transaksi.pdf');
    }
}
