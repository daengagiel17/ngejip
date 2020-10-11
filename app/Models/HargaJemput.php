<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaJemput extends Model
{
    protected $table = 'harga_jemput';
    protected $primaryKey = 'idharga_jemput';

    protected $fillable = [
    	'harga_jemput_lokasi', 'harga_jemput_nominal','harga_jemput_pertgl'
    ];

    // //
    // public function booking(){
    //     return $this->hasMany('App\Models\Booking','harga_jemput_idharga_jemput','idharga_jemput');
    //     // (Class relasi, foreign_key di class relasi, primary di local)
    // }

}
