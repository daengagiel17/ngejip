<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaAntar extends Model
{
    protected $table = 'harga_antar';
    protected $primaryKey = 'idharga_antar';

    protected $fillable = [
    	'harga_antar_lokasi', 'harga_antar_nominal','harga_antar_pertgl'
    ];

    // public function booking(){
    //     return $this->hasMany('App\Models\Booking','harga_antar_idharga_antar','idharga_antar');
    //     // (Class relasi, foreign_key di class relasi, primary di local)
    // }

}
