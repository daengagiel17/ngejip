<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverOff extends Model
{
    protected $table = 'driver_off';
    protected $primaryKey = 'iddriver_off';

    protected $fillable = [
    	'driver_off_tgl', 'driver_iddriver','driver_off_status'
    ];

    // many to one
    public function driver(){
    	return $this->belongsTo('App\Models\Driver','driver_iddriver','iddriver');
        // (Class relasi, foreign_key, primary_key)
    } 
}
