<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asesor_id')->nullable();
            $table->text('question');
            $table->string('question_type'); // @see config('options.soals_question_type')
            $table->string('answer_essay')->nullable();
            $table->string('answer_option')->nullable(); // @see config('options.soals_answer_option')
            $table->string('max_score');
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
        Schema::dropIfExists('soals');
    }
}
