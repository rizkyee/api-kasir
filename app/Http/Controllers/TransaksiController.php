<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransaksiService;
use App\Services\AktivitasUserService;

class TransaksiController extends Controller
{
    protected $service;
    protected $aktivitasService;


    public function __construct(TransaksiService $service, AktivitasUserService $aktivitasService)
    {
        $this->service = $service;
        $this->aktivitasService = $aktivitasService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $data = $this->service->listTransaksi($perPage);

        return response()->json([
            'message' => 'Data transaksi',
            'data'    => $data
        ]);
    }

    public function show($id)
    {
        $data = $this->service->detailTransaksi($id);

        if (!$data) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Detail transaksi',
            'data'    => $data
        ]);
    }

    public function store(Request $request)
    {
        $result = $this->service->storeTransaksi($request);

        if (isset($result['error'])) {
            return response()->json(['message' => $result['error']], $result['status']);
        }

        // Log aktivitas otomatis dengan no_invoice
        $this->aktivitasService->logAktivitas(
            'Tambah',
            'Transaksi',
            'Membuat transaksi baru ' . $result['data']->no_invoice,
            $request->user() // optional
        );

        return response()->json([
            'message' => 'Transaksi berhasil',
            'data'    => $result['data']
        ]);
    }
}
