<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikasiUnitKompentensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikasi_unit_kompentensis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order');
            $table->bigInteger('sertifikasi_id');
            $table->string('kode_unit_kompetensi');
            $table->string('title');
            $table->string('sub_title')->nullable();
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
        Schema::dropIfExists('sertifikasi_unit_kompentensis');
    }
}
