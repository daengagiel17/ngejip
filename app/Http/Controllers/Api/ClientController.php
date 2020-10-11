<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Booking;
use App\Models\HargaDetail;
use App\Models\HargaAntar;
use App\Models\HargaJemput;
use App\Models\HargaTiket;
use App\Models\HargaJeepDefault;
use App\Models\HargaJeepChanged;
use App\Models\AntrianDriver;
use App\Models\Driver;
use App\Models\DriverOff;
use App\Models\Transaksi;
use Midtrans;
use DateTime;
use DB;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:client-api');
        Veritrans::$serverKey = 'SB-Mid-server-Sa-PiWyclfXHpEcN0_R5WAO9';
        Veritrans::$isProduction = false;
    }

//     + type : post 
//     + url : /api/client/cek-harga
//     + fungsi : untuk mendapat data harga berdasar pencarian user
//     + request : tgl_booking, jmlh_penumpang, lokasi_antar, lokasi_jemput, jenis_trip
//     + response : booking, harga_antar, harga_jemput, harga_detail

    public function cekHarga(Request $request)
    {
        // Cek slot driver jika tidak ada maka diarahkan ke tanggal yang lain
        if($this->cekSlot($request->tgl_booking) == 0){
            return redirect()->back()->with('danger', 'Trip pada tanggal ini full, driver kami sedang tidak tersedia. Anda bisa mencari trip pada tanggal lain.');   
        }
        
        $tanggal_booking = $request->tgl_booking;
        // Membuat record harga detail
        $harga_detail = new HargaDetail;

        // Mengambil data harga change
        $harga_jeep = HargaJeepChanged::whereDate("harga_jeep_changed_tgl_start", "<=", $tanggal_booking)->whereDate("harga_jeep_changed_tgl_finish", ">=", $tanggal_booking)->first();

        // Jika tidak ada maka mengambil di harga default
        if(empty($harga_jeep)){
            $harga_jeep = HargaJeepDefault::orderByDesc('harga_jeep_default_pertanggal')->whereDate('harga_jeep_default_pertanggal', '<=', $tanggal_booking)->first();
            // Menginputkan nominal harga jika default ke harga detail
            $harga_detail->harga_detail_jeep = $harga_jeep->harga_jeep_default_nominal;
        }else{
            // Menginputkan nominal harga jika changed ke harga detail
            $harga_detail->harga_detail_jeep = $harga_jeep->harga_jeep_changed_nominal;
        }

        // Mencari harga antar sesuai tanggal
        $harga_antar = HargaAntar::orderByDesc('harga_antar_pertgl')->where('harga_antar_lokasi',$request->lokasi_antar)->whereDate('harga_antar_pertgl', '<=', $tanggal_booking)->first();

        // Mencari harga jemput sesuai tanggal
        $harga_jemput = HargaJemput::orderByDesc('harga_jemput_pertgl')->where('harga_jemput_lokasi',$request->lokasi_jemput)->whereDate('harga_jemput_pertgl', '<=', $tanggal_booking)->first();

        // Mencari harga tiket sesuai tanggal
        $harga_tiket = HargaTiket::orderByDesc('harga_tiket_pertanggal')->whereDate('harga_tiket_pertanggal', '<=', $tanggal_booking)->first();

        // Menginputkan nominal harga antar
        $harga_detail->harga_detail_antar = $harga_antar->harga_antar_nominal;
        // Menginputkan nominal harga jemput
        $harga_detail->harga_detail_jemput = $harga_jemput->harga_jemput_nominal;
        // Menginputkan nominal harga tiket
        $harga_detail->harga_detail_tiket = $harga_tiket->harga_tiket_weekend;

        //Save harga detail
        $harga_detail->save();

        //Menjumlahkan keseluruhan biaya
        $total_harga = $harga_detail->harga_detail_jeep + $harga_detail->harga_detail_antar + $harga_detail->harga_detail_jemput + ($harga_detail->harga_detail_tiket*$request->jmlh_penumpang);

        $booking = new Booking;
        $booking->booking_idphone = str_random(10);
        $booking->booking_jmlh_penumpang = $request->jmlh_penumpang;
        $booking->booking_tgl_berangkat = $tanggal_booking;
        $booking->booking_status = "ready";
        $booking->booking_status_pembayaran = "cek";
        $booking->harga_antar_idharga_antar = $harga_antar->idharga_antar;
        $booking->harga_jemput_idharga_jemput = $harga_jemput->idharga_jemput;
        $booking->harga_detail_idharga_detail = $harga_detail->idharga_detail;
        $booking->total_harga = $total_harga;
        $booking->transaksi_order_id = uniqid();
        $booking->save(); 

        return response()->json(compact('booking','harga_antar','harga_jemput','harga_detail'));
    }
    
//     + type : post 
//     + url : /api/client/pesan
//     + fungsi : memesan trip berdasarkan idbooking
//     + request : idbooking
//     + response : booking, harga_antar, harga_jemput, harga_detail

    public function pesan(Request $request)
    {
        $booking = Booking::findOrFail($request->idbooking);
        $booking->booking_status_pembayaran = "pesan";
        $booking->save();
        $harga_antar = HargaAntar::findOrFail($booking->harga_antar_idharga_antar);
        $harga_jemput = HargaJemput::findOrFail($booking->harga_jemput_idharga_jemput);
        $harga_detail = HargaDetail::findOrFail($booking->harga_detail_idharga_detail);

        return response()->json(compact('booking','harga_antar','harga_jemput','harga_detail'));
    }

//     + type : post 
//     + url : /api/client/bayar
//     + fungsi : mendapat token dari midtrans untuk melakukan pembayaran
//     + request : idbooking, nama_pemesan, no_hp_pemesan, email_pemesan
//     + response : token

    public function bayar(Request $request)
    {
        $booking = Booking::findOrFail($request->idbooking);

        $transaksi = Transaksi::where('order_id', $booking->transaksi_order_id)->first();
        if($transaksi){
            return response()->json('failed');
        }   
        $booking->booking_nama = $request->nama_pemesan;
        $booking->booking_nohp = $request->no_hp_pemesan;
        $booking->booking_email = $request->email_pemesan;
        $booking->booking_status_pembayaran = "pembayaran";
        // $booking->transaksi_order_id = uniqid();
        $booking->save();

        $harga_detail = HargaDetail::findOrFail($booking->harga_detail_idharga_detail);
        $transaction_details = [
            'order_id' => $booking->transaksi_order_id,
            'gross_amount' => $booking->total_harga //berdasarkan total transaksi
        ];
        
        $customer_details = [
            'first_name' => $booking->booking_nama,
            'email' => $booking->booking_email,
            'phone' => $booking->booking_nohp
        ];
        
        $custom_expiry = [
            'start_time' => date("Y-m-d H:i:s O", time()),
            'unit' => 'minute',
            'duration' => 200
        ];

        $tikets = [
            'id' => 'Tiket-'.$booking->idbooking,
            'quantity' => $booking->booking_jmlh_penumpang, 
            'name' => 'Tiket',
            'price' => $harga_detail->harga_detail_tiket
        ];

        $jeep = [
            'id' => 'Jeep-'.$booking->idbooking,
            'quantity' => 1, 
            'name' => 'Jeep',
            'price' => $harga_detail->harga_detail_jeep
        ];

        $antar = [
            'id' => 'Antar-'.$booking->idbooking,
            'quantity' => 1, 
            'name' => 'Antar',
            'price' => $harga_detail->harga_detail_antar
        ];

        $jemput = [
            'id' => 'Jemput-'.$booking->idbooking,
            'quantity' => 1, 
            'name' => 'Jemput',
            'price' => $harga_detail->harga_detail_jemput
        ];

        $item_details = [
            $jeep, $antar, $jemput, $tikets
        ];

        // Send this options if you use 3Ds in credit card request
        $credit_card_option = [
            'secure' => true, 
            'channel' => 'migs'
        ];

        $transaction_data = [
            'transaction_details' => $transaction_details,
            'item_details' => $item_details,
            'customer_details' => $customer_details,
            'expiry' => $custom_expiry,
            'credit_card' => $credit_card_option,
        ];

        $token = Midtrans::getSnapToken($transaction_data);
        
        return response()->json($token);
    }

    private function cekSlot($tanggal){
        $jmlDriver = Driver::count();
        $jmlSettlement = DB::table('booking')
            ->join('transaksi', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
            ->where('booking.booking_tgl_berangkat', '=', $tanggal)
            ->where('transaksi.transaction_status', 'settlement')
            ->count();  
        $jmlCapture = DB::table('booking')
            ->join('transaksi', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
            ->where('booking.booking_tgl_berangkat', '=', $tanggal)
            ->where('transaksi.transaction_status', 'capture')
            ->count();  
        $jmlPending = DB::table('booking')
            ->join('transaksi', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
            ->where('booking.booking_tgl_berangkat', '=', $tanggal)
            ->where('transaksi.transaction_status', 'pending')
            ->count();
        $jmlDriverOff = DriverOff::where('driver_off_tgl', $tanggal)->count();
        
        $slot = $jmlDriver - $jmlSettlement - $jmlPending - $jmlCapture - $jmlDriverOff - 1;

        return $slot;
    }

    public function cekPesanan(Request $request){
        $data = "Agiel";

        return response()->json($data);
    }    
}
