<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransaksiService;

class TransaksiController extends Controller
{
    protected $service;

    public function __construct(TransaksiService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->listTransaksi();
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

        return response()->json([
            'message' => 'Transaksi berhasil',
            'data'    => $result['data']
        ]);
    }

}
