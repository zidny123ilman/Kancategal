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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('foto');
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit');
            $table->integer('jumlah_halaman');
            $table->text('sinopsis');
            $table->string('bahasa');
            $table->string('kategori');
            $table->string('isbn');
            $table->text('tentang_penulis')->nullable();
            $table->string('status')->default('ready'); // ready, dipinjam
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
