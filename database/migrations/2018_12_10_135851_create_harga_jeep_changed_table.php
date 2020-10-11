<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHargaJeepChangedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_jeep_changed', function (Blueprint $table) {
            $table->increments('idharga_jeep_changed');
            $table->string('harga_jeep_changed_nominal');
            $table->string('harga_jeep_changed_jenis');
            $table->dateTime('harga_jeep_changed_tgl_start');
            $table->dateTime('harga_jeep_changed_tgl_finish');
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
        Schema::dropIfExists('harga_jeep_changed');
    }
}
