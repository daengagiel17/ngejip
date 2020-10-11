<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaJeepDefault extends Model
{
    protected $table = 'harga_jeep_default';
    protected $primaryKey = 'idharga_jeep_default';

    protected $fillable = [
        'harga_jeep_default_nominal', 'harga_jeep_default_pertanggal',
        'harga_jeep_default_jenis'
    ];
}
