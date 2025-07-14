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
        Schema::table('kpimetrics', function (Blueprint $table) {
            $table->float('weightages')->nullable()->after('bobot');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kpimetrics', function (Blueprint $table) {
            //
        });
    }
};
