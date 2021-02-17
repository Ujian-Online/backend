<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjianAsesiAsesorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian_asesi_asesors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asesi_id');
            $table->bigInteger('asesor_id');
            $table->bigInteger('ujian_jadwal_id');
            $table->bigInteger('sertifikasi_id');
            $table->bigInteger('order_id');
            $table->bigInteger('soal_paket_id')->nullable();
            $table->string('status'); // @see config('options.ujian_asesi_asesors_status')
            $table->boolean('is_kompeten')->nullable(); // @see config('options
            //.ujian_asesi_is_kompeten')
            $table->integer('final_score_percentage')->nullable();
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
        Schema::dropIfExists('ujian_asesi_asesors');
    }
}
