<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikasiTuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikasi_tuks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sertifikasi_id');
            $table->bigInteger('tuk_id');
            $table->decimal('tuk_price_baru', 12);
            $table->decimal('tuk_price_perpanjang', 12);
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
        Schema::dropIfExists('sertifikasi_tuks');
    }
}
