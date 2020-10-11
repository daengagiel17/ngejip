<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHargaDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_detail', function (Blueprint $table) {
            $table->increments('idharga_detail');
            $table->string('harga_detail_jeep');
            $table->string('harga_detail_antar');
            $table->string('harga_detail_jemput');
            $table->string('harga_detail_tiket');
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
        Schema::dropIfExists('harga_detail');
    }
}
