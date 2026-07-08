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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('nama')->nullable();
            $table->string('avatar')->nullable();
            $table->string('peran')->nullable();
            $table->integer('rating');
            $table->text('isi');
            $table->timestamps();
        });

        // Insert initial reviews
        \Illuminate\Support\Facades\DB::table('reviews')->insert([
            [
                'nama' => 'Silvia Fahmi',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=300',
                'peran' => 'Active Member',
                'rating' => 5,
                'isi' => 'Kanca Tegal has completely transformed my reading habits. The collection of local archives is outstanding, and the weekly book discussions are always inspiring.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Bintang Wijaya',
                'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=300',
                'peran' => 'Local Youth Advocate',
                'rating' => 5,
                'isi' => 'A wonderful space where traditional wisdom meets modern ideas! A place where community meets knowledge.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
