<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable
{
    use Notifiable;

    protected $table = 'driver';
    protected $primaryKey = 'iddriver';
    // protected $fillable = [
    //     'user_id', 'driver_jmlh_orderan',
    // ];

    protected $fillable = [
        'driver_username', 'driver_nama', 'driver_nohp', 'driver_photo', 'driver_jmlh_orderan',
        'email', 'email_verified_at', 'password', 'api_token', 
    ];

    // // one to one
    // public function user(){
    //     return $this->belongsTo('App\User');
    // }
    
    // one to many
    public function driver_off(){
        return $this->hasMany('App\Models\DriverOff','driver_iddriver','iddriver');
        // (Class relasi, foreign_key di class relasi, primary di local)
    }

    // one to many
    public function antrianDriver(){
        return $this->hasMany('App\Models\AntrianDriver','driver_iddriver','iddriver');
        // (Class relasi, foreign_key di class relasi, primary di local)
    }

}