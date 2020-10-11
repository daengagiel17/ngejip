<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'idadmin';

    protected $fillable = [
        'admin_nama', 'admin_nohp', 'admin_photo',
        'email', 'email_verified_at', 'password', 'api_token', 
    ];

}