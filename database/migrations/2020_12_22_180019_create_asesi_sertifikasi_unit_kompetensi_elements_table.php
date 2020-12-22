<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsesiSertifikasiUnitKompetensiElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asesi_sertifikasi_unit_kompetensi_elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_asesi_id');
            $table->bigInteger('unit_kompetensi_id');
            $table->text('desc');
            $table->text('upload_instruction');
            $table->string('media_url')->nullable();
            $table->boolean('is_verified');
            $table->text('verification_note')->nullable();
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
        Schema::dropIfExists('asesi_sertifikasi_unit_kompetensi_elements');
    }
}