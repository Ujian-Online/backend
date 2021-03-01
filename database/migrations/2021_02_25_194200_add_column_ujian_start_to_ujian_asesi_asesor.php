<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUjianStartToUjianAsesiAsesor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ujian_asesi_asesors', function (Blueprint $table) {
            $table->dateTime('ujian_start')->nullable()->after('soal_paket_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ujian_asesi_asesors', function (Blueprint $table) {
            //
        });
    }
}
