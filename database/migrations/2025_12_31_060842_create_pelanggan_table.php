<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->increments('id_pelanggan');
            $table->string('nama_pelanggan', 100);
            $table->string('alamat', 255)->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->enum('jenis_kelamin', ['L','P']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
