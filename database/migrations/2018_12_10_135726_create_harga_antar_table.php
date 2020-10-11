<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHargaAntarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_antar', function (Blueprint $table) {
            $table->increments('idharga_antar');
            $table->string('harga_antar_lokasi');
            $table->string('harga_antar_nominal');
            $table->dateTime('harga_antar_pertgl');
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
        Schema::dropIfExists('harga_antar');
    }
}
