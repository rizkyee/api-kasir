<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('detail_transaksi')) {
            return;
        }
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->integer('id_transaksi')->unsigned();
            $table->integer('id_produk')->unsigned();
            $table->integer('id_kategori')->unsigned();
            $table->string('produk', 100);
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('total', 14, 2);

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi');
            $table->foreign('id_produk')->references('id_produk')->on('produk');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
