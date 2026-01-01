<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('aktivitas_user')) {
            return;
        }
        Schema::create('aktivitas_user', function (Blueprint $table) {
            $table->id('id_aktivitas');
            $table->unsignedBigInteger('id_user');
            $table->string('aksi', 100);
            $table->string('modul', 100);
            $table->text('deskripsi')->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();

            // sesuaikan foreign key
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('aktivitas_user');
    }
};
