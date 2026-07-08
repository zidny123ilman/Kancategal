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
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('nama_uploader');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->date('tanggal_upload');
            $table->string('foto_utama');
            $table->longText('isi');
            $table->string('foto_pendukung')->nullable();
            $table->string('kategori');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
