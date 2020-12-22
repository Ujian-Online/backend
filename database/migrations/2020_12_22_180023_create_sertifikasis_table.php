<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikasis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomor_skema');
            $table->string('title');
            $table->float('original_price_baru');
            $table->float('original_price_perpanjang');
            $table->string('jenis_sertifikasi'); // @see config('options
            //.sertifikasis_jenis_sertifikasi')
            $table->boolean('is_active');
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
        Schema::dropIfExists('sertifikasis');
    }
}