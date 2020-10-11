<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaJeepChanged extends Model
{
    protected $table = 'harga_jeep_changed';
    protected $primaryKey = 'idharga_jeep_changed';

    protected $fillable = [
        'harga_jeep_changed_nominal', 'harga_jeep_changed_tgl_start',
        'harga_jeep_changed_tgl_finish','harga_jeep_changed_jenis'
    ];
}
