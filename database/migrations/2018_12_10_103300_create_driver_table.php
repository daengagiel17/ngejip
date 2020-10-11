<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('driver', function (Blueprint $table) {
        //     $table->increments('iddriver');
        //     $table->string('user_id')->unique();
        //     $table->integer('driver_jmlh_orderan');
        //     $table->timestamps();
        // });
        Schema::create('driver', function (Blueprint $table) {
            $table->increments('iddriver');
            $table->string('driver_username');
            $table->string('driver_nama');
            $table->string('driver_nohp');
            $table->string('driver_photo')->nullable();
            $table->integer('driver_jmlh_orderan');
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token',100)->unique();
            $table->rememberToken();
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
        Schema::dropIfExists('driver');
    }
}
