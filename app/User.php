<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nohp', 'status', 'photo', 'email', 'password', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'status', 'api_token'
    ];

    // // one to one
    // public function driver(){
    //     return $this->hasOne('App\Models\Driver');
    // }

    // one to many
    public function booking(){
        return $this->hasMany('App\Models\Booking');
    }

}