<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('job_position_id')->nullable()->after('id');
            $table->foreign('job_position_id')->references('id')->on('job_positions')->onDelete('set null');
        });

        Schema::table('kpimetrics', function (Blueprint $table) {
            $table->unsignedBigInteger('job_position_id')->after('id');
            $table->foreign('job_position_id')->references('id')->on('job_positions')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_and_kpimetrics', function (Blueprint $table) {
            //
        });
    }
};
