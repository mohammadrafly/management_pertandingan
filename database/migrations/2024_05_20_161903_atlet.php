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
        Schema::create('atlet', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('ttl');
            $table->enum('jk', ['l', 'p']);
            $table->string('bb');
            $table->string('foto')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('ijazah_karate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atlet');
    }
};
