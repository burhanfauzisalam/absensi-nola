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
            $table->enum('keterangan', ['Hadir', 'Ijin', 'Sakit', 'Online'])->default('Hadir');
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
