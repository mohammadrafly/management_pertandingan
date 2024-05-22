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
        Schema::create('list_tim', function (Blueprint $table) {
            $table->id();
            $table->string('tim_id');
            $table->string('atlet_id');
            $table->string('kelas_id')->nullable();
            $table->string('kode_beregu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_tim');
    }
};
