<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsesiUnitKompetensiDokumensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asesi_unit_kompetensi_dokumens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asesi_id');
            $table->bigInteger('unit_kompetensi_id');
            $table->string('order');
            $table->bigInteger('sertifikasi_id');
            $table->string('kode_unit_kompetensi');
            $table->string('title');
            $table->string('sub_title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asesi_unit_kompetensi_dokumens');
    }
}
