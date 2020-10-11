<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->increments('idbooking');
            $table->string('booking_idphone')->nullable();
            $table->string('user_id')->nullable();
            $table->dateTime('booking_tgl_berangkat');
            $table->string('booking_lokasi_antar');
            $table->string('booking_lokasi_jemput');
            $table->integer('booking_jmlh_penumpang');
            $table->string('booking_jenis_trip'); //open trip, private trip
            $table->string('booking_paket_trip'); //sunrise, panorama
            $table->string('booking_status')->nullable(); //ready, done
            $table->string('booking_status_pembayaran'); //cek, pesan, pembayaran, selesai
            $table->integer('total_harga')->nullable();
            $table->string('transaksi_order_id');
            $table->unsignedInteger('harga_detail_idharga_detail')->nullable();
            $table->foreign('harga_detail_idharga_detail')->references('idharga_detail')->on('harga_detail');
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
        Schema::dropIfExists('booking');
    }
}
