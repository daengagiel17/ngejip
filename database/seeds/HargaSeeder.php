<?php

use Illuminate\Database\Seeder;
use App\Models\HargaTiket;
use App\Models\HargaJemput;
use App\Models\HargaAntar;
use App\Models\HargaJeepChanged;
use App\Models\HargaJeepDefault;

class HargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cari cara disable tanggal yang sudah lewat
        // Tiket 
        $harga_tiket = new HargaTiket;
        $harga_tiket->harga_tiket_weekend = 15000;
        $harga_tiket->harga_tiket_weekday = 5000;
        $harga_tiket->harga_tiket_paket = "panorama";
        $harga_tiket->harga_tiket_pertanggal = date_create("2018-10-01");
        $harga_tiket->save();   

        $harga_tiket = new HargaTiket;
        $harga_tiket->harga_tiket_weekend = 30000;
        $harga_tiket->harga_tiket_weekday = 15000;
        $harga_tiket->harga_tiket_paket = "sunrise";
        $harga_tiket->harga_tiket_pertanggal = date_create("2018-10-01");
        $harga_tiket->save();   

        // Jemput
        $harga_jemput = new HargaJemput;
        $harga_jemput->harga_jemput_lokasi = "malang";
        $harga_jemput->harga_jemput_nominal = 25000;
        $harga_jemput->harga_jemput_pertgl = date_create("2018-10-01");
        $harga_jemput->save();   

        $harga_jemput = new HargaJemput;
        $harga_jemput->harga_jemput_lokasi = "batu";
        $harga_jemput->harga_jemput_nominal = 40000;
        $harga_jemput->harga_jemput_pertgl = date_create("2018-10-01");
        $harga_jemput->save();   

        $harga_jemput = new HargaJemput;
        $harga_jemput->harga_jemput_lokasi = "tumpang";
        $harga_jemput->harga_jemput_nominal = 0;
        $harga_jemput->harga_jemput_pertgl = date_create("2018-10-01");
        $harga_jemput->save();  

        $harga_jemput = new HargaJemput;
        $harga_jemput->harga_jemput_lokasi = "stasiun";
        $harga_jemput->harga_jemput_nominal = 0;
        $harga_jemput->harga_jemput_pertgl = date_create("2018-10-01");
        $harga_jemput->save();  

        // Antar
        $harga_antar = new HargaAntar;
        $harga_antar->harga_antar_lokasi = "malang";
        $harga_antar->harga_antar_nominal = 25000;
        $harga_antar->harga_antar_pertgl = date_create("2018-10-01");
        $harga_antar->save();   

        $harga_antar = new HargaAntar;
        $harga_antar->harga_antar_lokasi = "batu";
        $harga_antar->harga_antar_nominal = 40000;
        $harga_antar->harga_antar_pertgl = date_create("2018-10-01");
        $harga_antar->save();   

        $harga_antar = new HargaAntar;
        $harga_antar->harga_antar_lokasi = "tumpang";
        $harga_antar->harga_antar_nominal = 0;
        $harga_antar->harga_antar_pertgl = date_create("2018-10-01");
        $harga_antar->save(); 

        $harga_antar = new HargaAntar;
        $harga_antar->harga_antar_lokasi = "stasiun";
        $harga_antar->harga_antar_nominal = 0;
        $harga_antar->harga_antar_pertgl = date_create("2018-10-01");
        $harga_antar->save(); 

        // Jeep Default
        $harga_jeep_default = new HargaJeepDefault;
        $harga_jeep_default->harga_jeep_default_nominal = 45000;
        $harga_jeep_default->harga_jeep_default_jenis = "open";
        $harga_jeep_default->harga_jeep_default_pertanggal = date_create("2018-10-01");
        $harga_jeep_default->save();   

        $harga_jeep_default = new HargaJeepDefault;
        $harga_jeep_default->harga_jeep_default_nominal = 35000;
        $harga_jeep_default->harga_jeep_default_jenis = "private";
        $harga_jeep_default->harga_jeep_default_pertanggal = date_create("2018-10-01");
        $harga_jeep_default->save();   

        // Harga Jeep Changed
        $harga_jeep_changed = new HargaJeepChanged;
        $harga_jeep_changed->harga_jeep_changed_nominal = 67000;
        $harga_jeep_changed->harga_jeep_changed_jenis = "open";
        $harga_jeep_changed->harga_jeep_changed_tgl_start = date_create("2019-01-02");
        $harga_jeep_changed->harga_jeep_changed_tgl_finish = date_create("2019-01-04");
        $harga_jeep_changed->save();   

        $harga_jeep_changed = new HargaJeepChanged;
        $harga_jeep_changed->harga_jeep_changed_nominal = 60000;
        $harga_jeep_changed->harga_jeep_changed_jenis = "private";
        $harga_jeep_changed->harga_jeep_changed_tgl_start = date_create("2019-01-02");
        $harga_jeep_changed->harga_jeep_changed_tgl_finish = date_create("2019-01-04");
        $harga_jeep_changed->save();   
    }
}