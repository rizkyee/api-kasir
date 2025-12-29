<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('produk')) {

            Schema::create('produk', function (Blueprint $table) {
                $table->increments('id_produk');
                $table->string('nama_produk', 150);
                $table->integer('id_kategori')->unsigned();
                $table->decimal('harga', 12, 2);
                $table->integer('stok');
                $table->text('deskripsi')->nullable();
                $table->string('gambar_produk', 255)->nullable();

                $table->foreign('id_kategori')
                      ->references('id_kategori')
                      ->on('kategori')
                      ->onDelete('restrict');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
