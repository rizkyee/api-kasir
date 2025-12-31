<?php

namespace App\Services;

use App\Repositories\TransaksiRepository;
use Illuminate\Support\Facades\DB;

class TransaksiService
{
    protected $repo;

    public function __construct(TransaksiRepository $repo)
    {
        $this->repo = $repo;
    }

    public function listTransaksi()
    {
        return $this->repo->all();
    }

    public function detailTransaksi($id)
    {
        return $this->repo->findById($id);
    }

    public function storeTransaksi($request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'id_pelanggan' => 'required|integer',
                'id_metode'    => 'required|integer',
                'status'       => 'required',
                'items'        => 'required|array'
            ]);

            $noInvoice = 'INV-' . time();
            $total_harga = 0;

            foreach ($request->items as $item) {
                $produk = $this->repo->findProduk($item['id_produk']);
                if ($produk->stok < $item['jumlah']) {
                    return [
                        'error' => 'Stok tidak cukup untuk ' . $produk->nama_produk,
                        'status' => 422
                    ];
                }
                $total_harga += ($produk->harga * $item['jumlah']);
            }

            $transaksi = $this->repo->createTransaksi([
                'no_invoice'   => $noInvoice,
                'tanggal'      => now(),
                'id_pelanggan' => $request->id_pelanggan,
                'id_user'      => $request->user()->id_user,
                'total_harga'  => $total_harga,
                'status'       => $request->status,
                'id_metode'    => $request->id_metode,
            ]);

            foreach ($request->items as $item) {
                $produk = $this->repo->findProduk($item['id_produk']);
                $this->repo->createDetail([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_produk'    => $produk->id_produk,
                    'id_kategori'  => $produk->id_kategori,
                    'produk'       => $produk->nama_produk,
                    'jumlah'       => $item['jumlah'],
                    'harga_satuan' => $produk->harga,
                    'total'        => $produk->harga * $item['jumlah']
                ]);
                $produk->decrement('stok', $item['jumlah']);
            }

            DB::commit();
            return ['data' => $transaksi->load('detail')];

        } catch (\Throwable $e) {
            DB::rollBack();
            return [
                'error' => $e->getMessage(),
                'status' => 500
            ];
        }
    }
}
