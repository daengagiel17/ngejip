<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHargaJeepDefaultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_jeep_default', function (Blueprint $table) {
            $table->increments('idharga_jeep_default');
            $table->string('harga_jeep_default_nominal');
            $table->string('harga_jeep_default_jenis');
            $table->dateTime('harga_jeep_default_pertanggal');
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
        Schema::dropIfExists('harga_jeep_default');
    }
}
