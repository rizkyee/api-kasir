<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('laporan')) {
            return;
        }
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->string('jenis_laporan', 50);
            $table->timestamp('tanggal_cetak')->useCurrent();
            $table->unsignedBigInteger('id_user');
            $table->text('keterangan')->nullable();

            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
