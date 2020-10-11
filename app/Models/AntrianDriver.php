<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntrianDriver extends Model
{
    protected $table = 'antriandriver';
    protected $primaryKey = 'idantriandriver';

    protected $fillable = [
    	'antriandriver_finish', 'antriandriver_status', 'antriandriver_status_baca',
    	'antriandriver_tgl_jalan','antriandriver_qr','driver_iddriver', 'transaksi_order_id'
    ];

    // many to one
    public function driver(){
    	return $this->belongsTo('App\Models\Driver','driver_iddriver','iddriver');
    } 

    // many to one
    public function booking(){
        return $this->belongsTo('App\Models\Booking','transaksi_order_id','transaksi_order_id');
    }
}
