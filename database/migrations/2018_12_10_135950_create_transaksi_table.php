<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('transaction_id');
            $table->primary('transaction_id');
            $table->dateTime('transaction_time');
            $table->string('transaction_status');
            $table->string('status_message');
            $table->string('signature_key');
            $table->string('payment_type');
            $table->string('order_id');
            $table->integer('gross_amount');
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
        Schema::dropIfExists('transaksi');
    }
}
