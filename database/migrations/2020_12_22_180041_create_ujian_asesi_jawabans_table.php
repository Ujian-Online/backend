<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjianAsesiJawabansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian_asesi_jawabans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ujian_asesi_asesor_id');
            $table->bigInteger('soal_id');
            $table->bigInteger('asesi_id');
            $table->text('question');
            $table->string('question_type'); // @see config('options.ujian_asesi_jawabans_question_type')
            $table->text('answer_essay')->nullable();
            $table->string('answer_option')->nullable(); // @see config('options.ujian_asesi_jawabans_answer_option')
            $table->longText('options_label')->nullable();
            $table->integer('urutan'); //  (1, 2 dst)
            $table->text('user_answer')->nullable();
            $table->text('catatan_asesor')->nullable();
            $table->integer('max_score')->nullable();
            $table->integer('final_score')->nullable();
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
        Schema::dropIfExists('ujian_asesi_jawabans');
    }
}
