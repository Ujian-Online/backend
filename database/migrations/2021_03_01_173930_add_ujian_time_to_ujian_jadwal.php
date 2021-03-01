<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUjianTimeToUjianJadwal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ujian_jadwals', function (Blueprint $table) {
            $table->time('jam_mulai')->after('tanggal');
            $table->time('jam_berakhir')->after('jam_mulai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ujian_jadwals', function (Blueprint $table) {
            //
        });
    }
}
