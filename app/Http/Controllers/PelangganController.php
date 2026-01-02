<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PelangganService;

class PelangganController extends Controller
{
    protected $service;

    public function __construct(PelangganService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->listPelanggan();
        return response()->json([
            'message' => 'Data pelanggan',
            'data'    => $data
        ]);
    }

    public function show($id)
    {
        $data = $this->service->detailPelanggan($id);

        if (!$data) {
            return response()->json([
                'message' => 'Pelanggan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Detail pelanggan',
            'data'    => $data
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'alamat'         => 'nullable|string',
            'no_telp'        => 'nullable|string|max:20',
            'jenis_kelamin'  => 'required|in:L,P'
        ]);

        $pelanggan = $this->service->tambahPelanggan($validated);

        return response()->json([
            'message' => 'Pelanggan berhasil ditambahkan',
            'data'    => $pelanggan
        ], 201);
    }
}
