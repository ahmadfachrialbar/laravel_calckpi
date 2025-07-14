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
        Schema::table('kpi_records', function (Blueprint $table) {
            $table->renameColumn('realization', 'simulasi_penambahan');
            $table->float('achievement')->nullable()->after('simulasi_penambahan');
            $table->float('weightages')->nullable()->after('achievement');
        });
    }

    public function down()
    {
        Schema::table('kpi_records', function (Blueprint $table) {
            $table->renameColumn('simulasi_penambahan', 'realization');
            $table->dropColumn('achievement');
            $table->dropColumn('weightages');
        });
    }
};
