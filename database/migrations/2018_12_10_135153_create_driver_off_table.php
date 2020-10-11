<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverOffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_off', function (Blueprint $table) {
            $table->increments('iddriver_off');
            $table->string('driver_off_tgl')->dateTime();
            $table->string('driver_off_status'); //Aktif / Non Aktif
            $table->unsignedInteger('driver_iddriver');
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
        Schema::dropIfExists('driver_off');
    }
}
