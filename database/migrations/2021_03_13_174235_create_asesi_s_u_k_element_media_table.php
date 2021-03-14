<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsesiSUKElementMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asesi_s_u_k_element_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asesi_id');
            $table->bigInteger('asesi_suk_element_id');
            $table->text('description')->nullable();
            $table->text('media_url');
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
        Schema::dropIfExists('asesi_s_u_k_element_media');
    }
}
