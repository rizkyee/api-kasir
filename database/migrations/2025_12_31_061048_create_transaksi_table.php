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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('id_transaksi');
            $table->string('no_invoice', 20);
            $table->date('tanggal');
            $table->integer('id_pelanggan')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->decimal('total_harga', 14, 2);
            $table->enum('status', ['Lunas', 'Belum Lunas', 'Menunggu Pembayaran']);
            $table->integer('id_metode')->unsigned();

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan');
            $table->foreign('id_user')->references('id_user')->on('user');
            $table->foreign('id_metode')->references('id_metode')->on('metode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
