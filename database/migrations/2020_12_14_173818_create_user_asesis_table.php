<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAsesisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_asesis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unique();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->boolean('gender')->nullable(); // true = pria, false = wanita
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->boolean('has_job')->nullable(); // true = bekerja, false = tidak bekerja
            $table->string('job_title')->nullable();
            $table->text('job_address')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->bigInteger('user_id_admin')->nullable();
            $table->boolean('is_verified')->nullable();
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
        Schema::dropIfExists('user_asesis');
    }
}
