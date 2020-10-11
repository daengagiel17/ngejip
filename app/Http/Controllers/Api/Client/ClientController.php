<?php

namespace App\Http\Controllers\Api\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
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
use Auth;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->only(['setBooking', 'getBookings', 'getDetailBooking']);
        // $this->middleware('auth')->except(['index', 'cekHarga']);
        Veritrans::$serverKey = 'SB-Mid-server-Sa-PiWyclfXHpEcN0_R5WAO9';
        Veritrans::$isProduction = false;
    }

    // Req : $nama, $nohp, $email, $idotp
    public function setAccount(Request $request){
        // register akun customer
        $user = new User;
        $user->name = $request->nama;
        $user->nohp = $request->nohp;
        $user->email = $request->email;
        $user->password = bcrypt($request->idotp);
        $user->api_token = str_random(100);
        $user->save();

        return response()->json($user);
    }

    public function getAccount($nohp){
        // return detail data account
        $user = User::where('nohp', $nohp)->first();
        if($user == null){
            return response()->json("User not found");
        }

        return response()->json($user);
    }

    // Req : tgl_booking, lokasi_antar, lokasi_jemput, jmlh_penumpang, paket_trip    
    public function getHargaPrivate(Request $request){
        // Cek slot driver jika tidak ada maka diarahkan ke tanggal yang lain
        if($this->cekSlot($request->tgl_booking) == 0){
            return response()->json("Driver not found");   
        }

        $tanggal_booking = $request->tgl_booking;

        // Membuat record harga detail
        $harga_detail = new HargaDetail;

        // Mengambil data harga change
        $harga_jeep = HargaJeepChanged::where('harga_jeep_changed_jenis', "private")
            ->whereDate("harga_jeep_changed_tgl_start", "<=", $tanggal_booking)
            ->whereDate("harga_jeep_changed_tgl_finish", ">=", $tanggal_booking)
            ->first();

        // Jika tidak ada maka mengambil di harga default
        if(empty($harga_jeep)){
            $harga_jeep = HargaJeepDefault::orderByDesc('harga_jeep_default_pertanggal')
            ->whereDate('harga_jeep_default_pertanggal', '<=', $tanggal_booking)
            ->where('harga_jeep_default_jenis', "private")
            ->first();
            // Menginputkan nominal harga jika default ke harga detail
            $harga_detail->harga_detail_jeep = $harga_jeep->harga_jeep_default_nominal;
        }else{
            // Menginputkan nominal harga jika changed ke harga detail
            $harga_detail->harga_detail_jeep = $harga_jeep->harga_jeep_changed_nominal;
        }

        // Mencari harga antar sesuai tanggal
        $harga_antar = HargaAntar::orderByDesc('harga_antar_pertgl')->where('harga_antar_lokasi',$request->lokasi_antar)
            ->whereDate('harga_antar_pertgl', '<=', $tanggal_booking)->first();

        // Mencari harga jemput sesuai tanggal
        $harga_jemput = HargaJemput::orderByDesc('harga_jemput_pertgl')->where('harga_jemput_lokasi',$request->lokasi_jemput)
            ->whereDate('harga_jemput_pertgl', '<=', $tanggal_booking)->first();

        // Mencari harga tiket sesuai tanggal
        $harga_tiket = HargaTiket::orderByDesc('harga_tiket_pertanggal')->where('harga_tiket_paket',$request->paket_trip)
            ->whereDate('harga_tiket_pertanggal', '<=', $tanggal_booking)->first();

        // Menginputkan nominal harga antar
        $harga_detail->harga_detail_antar = $harga_antar->harga_antar_nominal;
        // Menginputkan nominal harga jemput
        $harga_detail->harga_detail_jemput = $harga_jemput->harga_jemput_nominal;

        // Belum mengeset paket tiket weekend dan weekday
        // Menginputkan nominal harga tiket
        $harga_detail->harga_detail_tiket = $harga_tiket->harga_tiket_weekend;

        //Save harga detail
        $harga_detail->save();

        // Cara menjumlahkan antara Open dan Private berbeda
        //Menjumlahkan keseluruhan biaya
        $total_harga = $harga_detail->harga_detail_jeep + $harga_detail->harga_detail_antar + $harga_detail->harga_detail_jemput + ($harga_detail->harga_detail_tiket*$request->jmlh_penumpang);

        $booking = new Booking;
        $booking->booking_idphone = str_random(10);
        $booking->booking_tgl_berangkat = $tanggal_booking;
        $booking->booking_lokasi_jemput = $request->lokasi_jemput;
        $booking->booking_lokasi_antar = $request->lokasi_antar;
        $booking->booking_jmlh_penumpang = $request->jmlh_penumpang;
        $booking->booking_jenis_trip = "private";
        $booking->booking_paket_trip = $request->paket_trip;
        $booking->booking_status = "ready";
        $booking->booking_status_pembayaran = "cek";
        $booking->harga_detail_idharga_detail = $harga_detail->idharga_detail;
        $booking->total_harga = $total_harga;
        $booking->transaksi_order_id = uniqid();
        $booking->save(); 
        
        $dataBooking = [
            "harga_jeep" => $harga_detail->harga_detail_jeep, 
            "harga_jemput" => $harga_detail->harga_detail_jemput,
            "harga_antar" => $harga_detail->harga_detail_antar,
            "harga_tiket" => $harga_detail->harga_detail_tiket,
            "total" => $total_harga, 
            "id_order" => $booking->transaksi_order_id
        ];
        // dd($dataBooking);
        return response()->json($dataBooking);
    }

    // Req : tgl_booking, jmlh_penumpang
    public function getHargaOpen(Request $request){
        $tanggal_booking = $request->tgl_booking;

        // Membuat record harga detail
        $harga_detail = new HargaDetail;

        // Mengambil data harga change
        $harga_jeep = HargaJeepChanged::whereDate("harga_jeep_changed_tgl_start", "<=", $tanggal_booking)
            ->whereDate("harga_jeep_changed_tgl_finish", ">=", $tanggal_booking)
            ->where('harga_jeep_changed_jenis', "open")
            ->first();

        // Jika tidak ada maka mengambil di harga default
        if(empty($harga_jeep)){
            $harga_jeep = HargaJeepDefault::orderByDesc('harga_jeep_default_pertanggal')
            ->whereDate('harga_jeep_default_pertanggal', '<=', $tanggal_booking)
            ->where('harga_jeep_default_jenis', "open")
            ->first();
            // Menginputkan nominal harga jika default ke harga detail
            $harga_detail->harga_detail_jeep = $harga_jeep->harga_jeep_default_nominal;
        }else{
            // Menginputkan nominal harga jika changed ke harga detail
            $harga_detail->harga_detail_jeep = $harga_jeep->harga_jeep_changed_nominal;
        }

        // Mencari harga antar sesuai tanggal
        $harga_antar = HargaAntar::orderByDesc('harga_antar_pertgl')->where('harga_antar_lokasi', "stasiun")
            ->whereDate('harga_antar_pertgl', '<=', $tanggal_booking)->first();

        // Mencari harga jemput sesuai tanggal
        $harga_jemput = HargaJemput::orderByDesc('harga_jemput_pertgl')->where('harga_jemput_lokasi', "stasiun")
            ->whereDate('harga_jemput_pertgl', '<=', $tanggal_booking)->first();

        // Mencari harga tiket sesuai tanggal
        $harga_tiket = HargaTiket::orderByDesc('harga_tiket_pertanggal')->where('harga_tiket_paket', "sunrise")
            ->whereDate('harga_tiket_pertanggal', '<=', $tanggal_booking)->first();

        // Menginputkan nominal harga antar
        $harga_detail->harga_detail_antar = $harga_antar->harga_antar_nominal;
        // Menginputkan nominal harga jemput
        $harga_detail->harga_detail_jemput = $harga_jemput->harga_jemput_nominal;
        
        // Belum melakukan set tanggal weekend dan tgl weekday
        // Menginputkan nominal harga tiket
        $harga_detail->harga_detail_tiket = $harga_tiket->harga_tiket_weekend;

        //Save harga detail
        $harga_detail->save();

        // Cara menjumlahkan antara Open dan Private berbeda
        //Menjumlahkan keseluruhan biaya
        $total_harga = ($harga_detail->harga_detail_jeep + $harga_detail->harga_detail_antar + $harga_detail->harga_detail_jemput + $harga_detail->harga_detail_tiket) * $request->jmlh_penumpang;

        $booking = new Booking;
        $booking->booking_idphone = str_random(10);
        $booking->booking_tgl_berangkat = $tanggal_booking;
        $booking->booking_lokasi_jemput = "stasiun";
        $booking->booking_lokasi_antar = "stasiun";
        $booking->booking_jmlh_penumpang = $request->jmlh_penumpang;
        $booking->booking_jenis_trip = "open";
        $booking->booking_paket_trip = "sunrise";
        $booking->booking_status = "ready";
        $booking->booking_status_pembayaran = "cek";
        $booking->harga_detail_idharga_detail = $harga_detail->idharga_detail;
        $booking->total_harga = $total_harga;
        $booking->transaksi_order_id = uniqid();
        $booking->save(); 

        $dataBooking = [
            "harga_jeep" => $harga_detail->harga_detail_jeep, 
            "harga_jemput" => $harga_detail->harga_detail_jemput,
            "harga_antar" => $harga_detail->harga_detail_antar,
            "harga_tiket" => $harga_detail->harga_detail_tiket,
            "total" => $total_harga, 
            "id_order" => $booking->transaksi_order_id
        ];

        return response()->json($dataBooking);
    }

    public function setBooking($id_order){
        // mengubah status pesan jadi pembayaran
        $booking = Booking::where('transaksi_order_id', $id_order)->first();
        $booking->booking_status_pembayaran = "pembayaran";
        $booking->save();

        return response()->json($id_order);
    }

    public function getBookings(){
        // mengambil data booking berdasarkan id user
        $bookings = Booking::where('user_id', Auth::guard('api')->id())->get();
        return response()->json($bookings);
    }
    
    public function getDetailBooking($id_order){
        // mengambil data detail booking berdasarkan id order
        $booking = Booking::where('transaksi_order_id', $id_order)->first();
        return response()->json($booking);
    }
        
    private function cekSlot($tanggal){
        $jmlDriver = Driver::count();
        $jmlSettlement = DB::table('booking')
            ->join('transaksi', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
            ->where('booking.booking_tgl_berangkat', '=', $tanggal)
            ->where('booking.booking_jenis_trip', '=', "private")
            ->where('transaksi.transaction_status', 'settlement')
            ->count();  
        $jmlCapture = DB::table('booking')
            ->join('transaksi', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
            ->where('booking.booking_tgl_berangkat', '=', $tanggal)
            ->where('booking.booking_jenis_trip', '=', "private")
            ->count();  
        $jmlPending = DB::table('booking')
            ->join('transaksi', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
            ->where('booking.booking_tgl_berangkat', '=', $tanggal)
            ->where('booking.booking_jenis_trip', '=', "private")
            ->where('transaksi.transaction_status', 'pending')
            ->count();
        $jmlDriverOff = DriverOff::where('driver_off_tgl', $tanggal)->count();
        
        // selalu kurangi satu slot untuk cadangan
        $slot = $jmlDriver - $jmlSettlement - $jmlPending - $jmlCapture - $jmlDriverOff - 1;

        return $slot;
    }

}
