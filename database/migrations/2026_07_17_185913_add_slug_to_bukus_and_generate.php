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
        Schema::table('bukus', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('judul');
        });

        // Generate slugs for existing bukus
        $bukus = \App\Models\Buku::all();
        foreach ($bukus as $buku) {
            $buku->slug = \Illuminate\Support\Str::slug($buku->judul) . '-' . $buku->id; // prevent duplicate if same titles
            $buku->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
