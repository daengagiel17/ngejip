<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Transaksi;
use App\Models\AntrianDriver;
use DB;

class TripController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
        
    public function index()
    {
        $trips = DB::table('transaksi')
        ->join('antriandriver', 'antriandriver.transaksi_order_id', '=', 'transaksi.order_id')
        ->join('booking', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
        ->join('driver', 'antriandriver.driver_iddriver', '=', 'driver.iddriver')
        ->where('transaksi.transaction_status', '=', 'settlement')
        ->where('antriandriver.antriandriver_status', '=', 'accepted')
        ->get();

        $jmlh_ready = $trips->where('booking_status','ready')->count();
        $jmlh_otw = $trips->where('booking_status','otw')->count();
        $jmlh_finish = $trips->where('booking_status','finish')->count();

        return view("admin.kelola trip.daftar trip", compact('trips','jmlh_ready','jmlh_otw','jmlh_finish'));
    }

    public function show($order_id)
    {
        $data = DB::table('transaksi')
        ->join('antriandriver', 'antriandriver.transaksi_order_id', '=', 'transaksi.order_id')
        ->join('booking', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
        ->join('driver', 'antriandriver.driver_iddriver', '=', 'driver.iddriver')
        ->join('harga_antar', 'harga_antar.idharga_antar', '=', 'booking.harga_antar_idharga_antar')
        ->join('harga_jemput', 'harga_jemput.idharga_jemput', '=', 'booking.harga_jemput_idharga_jemput')
        ->join('harga_detail', 'harga_detail.idharga_detail', '=', 'booking.harga_detail_idharga_detail')
        ->where('antriandriver.antriandriver_status', '=', 'accepted')
        ->where('transaksi.order_id', $order_id)
        ->first();

        return view("admin.kelola trip.detail trip", compact('data'));
    }

    public function ready(){
        $trips = DB::table('transaksi')
        ->join('antriandriver', 'antriandriver.transaksi_order_id', '=', 'transaksi.order_id')
        ->join('booking', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
        ->join('driver', 'antriandriver.driver_iddriver', '=', 'driver.iddriver')
        ->where('transaksi.transaction_status', '=', 'settlement')
        ->where('antriandriver.antriandriver_status', '=', 'accepted')
        ->where('booking.booking_status', '=', 'ready')
        ->get();

        $jumlah = $trips->count();

        return view("admin.kelola trip.trip ready", compact('trips','jumlah'));
    }

    public function otw(){
        $trips = DB::table('transaksi')
        ->join('antriandriver', 'antriandriver.transaksi_order_id', '=', 'transaksi.order_id')
        ->join('booking', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
        ->join('driver', 'antriandriver.driver_iddriver', '=', 'driver.iddriver')
        ->where('transaksi.transaction_status', '=', 'settlement')
        ->where('antriandriver.antriandriver_status', '=', 'accepted')
        ->where('booking.booking_status', '=', 'otw')
        ->get();

        $jumlah = $trips->count();

        return view("admin.kelola trip.trip otw", compact('trips','jumlah'));
    }

    public function finish(){
        $trips = DB::table('transaksi')
        ->join('antriandriver', 'antriandriver.transaksi_order_id', '=', 'transaksi.order_id')
        ->join('booking', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
        ->join('driver', 'antriandriver.driver_iddriver', '=', 'driver.iddriver')
        ->where('transaksi.transaction_status', '=', 'settlement')
        ->where('antriandriver.antriandriver_status', '=', 'accepted')
        ->where('booking.booking_status', '=', 'finish')
        ->get();

        $jumlah = $trips->count();

        return view("admin.kelola trip.trip finish", compact('trips','jumlah'));
    }

    public function byDate($tanggal){
        $trips = DB::table('transaksi')
        ->join('antriandriver', 'antriandriver.transaksi_order_id', '=', 'transaksi.order_id')
        ->join('booking', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
        ->join('driver', 'antriandriver.driver_iddriver', '=', 'driver.iddriver')
        ->where('transaksi.transaction_status', '=', 'settlement')
        ->where('antriandriver.antriandriver_status', '=', 'accepted')
        ->whereDate('booking.booking_tgl_berangkat', '=', $tanggal)
        ->get();

        return view("admin.kelola trip.trip by date", compact('trips','tanggal'));
    }
}
