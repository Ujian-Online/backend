<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asesi_id');
            $table->bigInteger('sertifikasi_id');
            $table->bigInteger('tuk_id');
            $table->string('tipe_sertifikasi'); // @see config('options.orders_tipe_sertifikasi')
            $table->string('kode_sertifikat')->nullable();
            $table->float('original_price');
            $table->float('tuk_price');
            $table->float('tuk_price_training')->nullable();
            $table->string('status'); // @see config('options.orders_status')
            $table->text('comment_rejected')->nullable();
            $table->text('comment_verification')->nullable();
            $table->string('transfer_from_bank_name')->nullable();
            $table->string('transfer_from_bank_account')->nullable();
            $table->integer('transfer_from_bank_number')->nullable();
            $table->string('transfer_to_bank_name')->nullable();
            $table->string('transfer_to_bank_account')->nullable();
            $table->integer('transfer_to_bank_number')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('media_url_bukti_transfer')->nullable();
            $table->date('expired_date');
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
        Schema::dropIfExists('orders');
    }
}
