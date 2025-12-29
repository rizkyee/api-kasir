<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ➜ kalau SUDAH ADA, jangan buat lagi
        if (! Schema::hasTable('kategori')) {

            Schema::create('kategori', function (Blueprint $table) {
                $table->increments('id_kategori');
                $table->string('nama_kategori', 50);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};
