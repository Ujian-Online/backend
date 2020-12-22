<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAssesisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_assesis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('name');
            $table->text('address');
            $table->boolean('gender'); // true = pria, false = wanita
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('no_ktp');
            $table->string('pendidikan_terakhir');
            $table->boolean('has_job'); // true = bekerja, false = tidak bekerja
            $table->string('job_title')->nullable();
            $table->text('job_address')->nullable();
            $table->string('media_url_sign_admin')->nullable(); // url gambar/canvas untuk ttd admin yang approve
            $table->bigInteger('user_id_admin')->nullable();
            $table->string('media_url_sign_user')->nullable();; // url gambar/canvas untuk ttd assesi
            $table->text('note_admin')->nullable();
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
        Schema::dropIfExists('user_assesis');
    }
}
