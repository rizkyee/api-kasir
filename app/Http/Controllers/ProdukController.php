<?php

namespace App\Http\Controllers;

use App\Services\ProdukService;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function __construct(protected ProdukService $service) {}

    public function index()
    {
        return response()->json([
            'status' => true,
            'data'   => $this->service->all()
        ]);
    }
    public function show($id)
    {
        $produk = $this->service->find($id);

        if (! $produk) {
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $produk
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|max:150',
            'id_kategori' => 'required|integer',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'deskripsi'   => 'nullable',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

        ]);

        $data = $request->all();

        if ($request->hasFile('gambar_produk')) {
            $file = $request->file('gambar_produk');
            $path = $file->store('produk', 'public');  
            $data['gambar_produk'] = $path;
        }

        $produk = $this->service->create($data);



        if (! $produk) {
            return response()->json([
                'status'  => false,
                'message' => 'Kategori tidak ditemukan'
            ], 422);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Produk berhasil ditambahkan',
            'data'    => $produk
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk'   => 'sometimes|max:150',
            'id_kategori'   => 'sometimes|integer',
            'harga'         => 'sometimes|numeric',
            'stok'          => 'sometimes|integer',
            'deskripsi'     => 'nullable',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

 

        $data = $request->all();

        unset($data['gambar_produk']);


        // kalau ada gambar baru
        if ($request->hasFile('gambar_produk')) {
            $file = $request->file('gambar_produk');
            $path = $file->store('produk', 'public');

            $data['gambar_produk'] = $path;
        }

        $produk = $this->service->update($id, $data);

        if ($produk === null) {
            return response()->json([
                'status'  => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        if ($produk === false) {
            return response()->json([
                'status'  => false,
                'message' => 'Kategori tidak ditemukan'
            ], 422);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Produk berhasil diperbarui',
            'data'    => $produk
        ]);
    }



    public function destroy($id)
    {
        $deleted = $this->service->delete($id);

        if (! $deleted) {
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}
