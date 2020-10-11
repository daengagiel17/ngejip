<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaTiket extends Model
{
    protected $table = 'harga_tiket';
    protected $primaryKey = 'idharga_tiket';

    protected $fillable = [
        'harga_tiket_weekend', 'harga_tiket_weekday','harga_tiket_pertanggal',
        'harga_tiket_paket'
    ];

}
