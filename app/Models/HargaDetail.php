<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaDetail extends Model
{
    protected $table = 'harga_detail';
    protected $primaryKey = 'idharga_detail';

    protected $fillable = [
    	'harga_detail_jeep', 'harga_detail_antar','harga_detail_jemput','harga_detail_tiket',
    ];

    // one to one
    public function booking(){
        return $this->hasOne('App\Models\Booking','harga_detail_idharga_detail','idharga_detail');
        // (Class relasi, foreign_key di class relasi, primary di local)
    }

}
