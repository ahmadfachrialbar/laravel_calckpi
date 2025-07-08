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
        Schema::create('kpi_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('metric_id');

            $table->float('nilai_actual')->default(0);
            $table->float('nilai_simulasi')->nullable();
            $table->float('nilai_achievement')->nullable();
            $table->float('nilai_weightages')->nullable();
            $table->float('nilai_score')->nullable();

            $table->integer('bulan')->nullable(); // Tambahan
            $table->integer('tahun')->nullable(); // Tambahan

            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('metric_id')->references('metric_id')->on('kpi_metrics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_records');
    }
};
