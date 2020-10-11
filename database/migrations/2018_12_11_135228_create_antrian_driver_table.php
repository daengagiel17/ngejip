<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntrianDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antriandriver', function (Blueprint $table) {
            $table->increments('idantriandriver');
            $table->dateTime('antriandriver_finish')->nullable();
            $table->string('antriandriver_status')->nullable(); // accepted / declined / off
            $table->string('antriandriver_status_baca'); // baca / belum
            $table->dateTime('antriandriver_tgl_jalan')->nullable();
            $table->string('antriandriver_qr')->unique();
            $table->unsignedInteger('driver_iddriver');
            $table->foreign('driver_iddriver')->references('iddriver')->on('driver');
            $table->string('transaksi_order_id');
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
        Schema::dropIfExists('antriandriver');
    }
}
