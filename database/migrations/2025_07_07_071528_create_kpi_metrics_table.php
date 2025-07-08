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
        Schema::create('KpiMetrics', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kpi');
            $table->text('penjelasan_sederhana')->nullable();
            $table->text('cara_ukur')->nullable();
            $table->float('target');
            $table->float('bobot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('KpiMetrics');
    }
};
