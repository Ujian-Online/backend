<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisUjianToSoalPakets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('soal_pakets', function (Blueprint $table) {
            $table->string('jenis_ujian')->after('durasi_ujian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('soal_pakets', function (Blueprint $table) {
            //
        });
    }
}
