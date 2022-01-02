<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsesiUnitKompetensiDokumenVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asesi_unit_kompetensi_dokumen_verifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asesi_id');
            $table->bigInteger('asesor_id')->nullable();
            $table->bigInteger('sertifikasi_id')->nullable();
            $table->text('recommendation')->nullable();
            $table->boolean('jenis_pengalaman')->default(false);
            $table->date('asesi_verification_date')->nullable();
            $table->date('asesor_verification_date')->nullable();
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
        Schema::dropIfExists('asesi_unit_kompetensi_dokumen_verifications');
    }
}
