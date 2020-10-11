<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'transaction_id';
    
    public $incrementing = false;

    protected $fillable = [
    	'transaction_time', 'transaction_status','status_message','signature_key',
    	'payment_type', 'order_id','gross_amount',
    ];

    // one to one
    public function booking(){
        return $this->hasOne('App\Models\Booking','transaksi_order_id','order_id');
        // (Class relasi, foreign_key di class relasi, primary di local)
    }
}
