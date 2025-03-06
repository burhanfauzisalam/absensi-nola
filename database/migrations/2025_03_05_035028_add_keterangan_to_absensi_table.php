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
        Schema::table('absensi', function (Blueprint $table) {
            $table->enum('keterangan', ['Offline', 'Ijin', 'Sakit', 'Online', 'Alfa'])->default('Offline');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }

};
