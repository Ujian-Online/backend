<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAsesiCustomDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_asesi_custom_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asesi_id');
            $table->string('title');
            $table->string('input_type');
            $table->text('value');
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
        Schema::dropIfExists('user_asesi_custom_data');
    }
}
