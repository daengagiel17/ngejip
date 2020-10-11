<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'idbooking';

    protected $fillable = [
        'booking_idphone', 'user_id', 'booking_tgl_berangkat', 'booking_lokasi_jemput', 
        'booking_lokasi_antar', 'booking_jmlh_penumpang', 'booking_jenis_trip', 'booking_paket_trip',
        'booking_status', 'booking_status_pembayaran', 'harga_detail_idharga_detail','transaksi_order_id'
    ];

    // one to many
    public function antrianDriver(){
    	return $this->hasMany('App\Models\AntrianDriver','transaksi_order_id','transaksi_order_id');
        // (Class relasi, foreign_key, primary_key)
    }  

    // many to one
    public function user(){
        return $this->belongsTo('App\User');
    }

    // public function hargaAntar(){
    // 	return $this->belongsTo('App\Models\HargaAntar','harga_antar_idharga_antar','idharga_antar');
    //      // (Class relasi, foreign_key, primary_key)
    // }  

    // public function hargaJemput(){
    // 	return $this->belongsTo('App\Models\HargaJemput','harga_jemput_idharga_jemput','idharga_jemput');
    //     // (Class relasi, foreign_key, primary_key)
    // }  

    // one to one
    public function hargaDetail(){
    	return $this->belongsTo('App\Models\HargaDetail','harga_detail_idharga_detail','idharga_detail');
        // (Class relasi, foreign_key, primary_key)
    }  

    // one to one
    public function transaksi(){
        return $this->belongsTo('App\Models\Transaksi','transaksi_order_id','order_id');
        // (Class relasi, foreign_key, primary_key)
    }

    
}