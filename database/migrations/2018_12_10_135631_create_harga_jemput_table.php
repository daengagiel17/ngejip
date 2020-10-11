<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHargaJemputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_jemput', function (Blueprint $table) {
            $table->increments('idharga_jemput');
            $table->string('harga_jemput_lokasi');
            $table->string('harga_jemput_nominal');
            $table->dateTime('harga_jemput_pertgl');
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
        Schema::dropIfExists('harga_jemput');
    }
}
