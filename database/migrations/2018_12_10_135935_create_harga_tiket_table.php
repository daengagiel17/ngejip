<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHargaTiketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_tiket', function (Blueprint $table) {
            $table->increments('idharga_tiket');
            $table->string('harga_tiket_paket');
            $table->string('harga_tiket_weekend');
            $table->string('harga_tiket_weekday');
            $table->dateTime('harga_tiket_pertanggal');
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
        Schema::dropIfExists('harga_tiket');
    }
}
