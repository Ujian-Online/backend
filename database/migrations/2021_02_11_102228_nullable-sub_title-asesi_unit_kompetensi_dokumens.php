<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableSubTitleAsesiUnitKompetensiDokumens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asesi_unit_kompetensi_dokumens', function (Blueprint $table) {
            $table->string('sub_title')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asesi_unit_kompetensi_dokumens', function (Blueprint $table) {
            //
        });
    }
}
