<?php

namespace App\Http\Controllers\Client;

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
use App\Models\Driver;
use App\Models\DriverOff;
use App\Models\Transaksi;
use App\Veritrans\Veritrans;
use Midtrans;
use DateTime;
use DB;
use Auth;

class BookingController extends Controller
{
    private $hargaTotal;
    
    public function __construct()
    {
        // $this->middleware('auth')->except(['index', 'cekHarga']);
        Veritrans::$serverKey = 'SB-Mid-server-Sa-PiWyclfXHpEcN0_R5WAO9';
        Veritrans::$isProduction = false;
    }

    public function index()
    {
        $datetime = new DateTime('tomorrow');
        $tomorrow = $datetime->format('Y-m-d');
        return view("client/index",compact('tomorrow'));
    }

    public function cekHargaPrivate(Request $request)
    {
        $request->validate([
            'tgl_booking' => 'required|date',
            'lokasi_antar' => 'required',
            'lokasi_jemput' => 'required',
            'jmlh_penumpang' => 'required',
            'paket_trip' => 'required',
        ],[
            'tgl_booking.required' => 'Tanggal booking is required',
            'tgl_booking.date' => 'Tanggal booking invalid format',
            'lokasi_antar.required' => 'Lokasi antar is required',
            'lokasi_jemput.required' => 'Lokas jemput booking is required',
            'jmlh_penumpang.required' => 'Jumlah penumpang is required',
            'paket_trip.required' => 'Paket trip is required',
        ]);

        // Cek slot driver jika tidak ada maka diarahkan ke tanggal yang lain
        if($this->cekSlot($request->tgl_booking) == 0){
            return redirect()->back()->with('danger', 'Trip pada tanggal ini full, driver kami sedang tidak tersedia. Anda bisa mencari trip pada tanggal lain.');   
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
                
        return redirect()->route('list-harga', $booking->transaksi_order_id);
    }

    public function cekHargaOpen(Request $request)
    {
        $request->validate([
            'tgl_booking' => 'required|date',
            'jmlh_penumpang' => 'required',
        ],[
            'tgl_booking.required' => 'Tanggal booking is required',
            'tgl_booking.date' => 'Tanggal booking invalid format',
            'jmlh_penumpang.required' => 'Jumlah penumpang is required',
        ]);

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
                
        return redirect()->route('list-harga', $booking->transaksi_order_id);
    }

    public function listHarga($idorder)
    {
        $booking = Booking::where('transaksi_order_id', $idorder)->firstOrFail();
        $harga_detail = HargaDetail::findOrFail($booking->harga_detail_idharga_detail);

        return view('client/list-harga', compact('booking', 'harga_detail'));
    }

    public function pesan(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login-otp', ['state' => "list-harga ".$request->transaksi_order_id]);            
        }

        // Seleksi untuk mencegah duplicate idorder transaksi pada midtrans 
        $transaksi = Transaksi::where('order_id', $request->transaksi_order_id)->first();
        if($transaksi){
            return redirect()->route('detail-pesanan', $request->transaksi_order_id)->with('danger', 'Kami mendeteksi pesanan anda sebelumnya. Jika ingin memesan lagi silahkan ke homepage.');
        }

        // Set user yang melakukan booking
        $booking = Booking::where('transaksi_order_id', $request->transaksi_order_id)->firstOrFail();
        $booking->user_id = Auth::id();
        $booking->booking_status_pembayaran = "pesan";
        $booking->save();

        $harga_detail = HargaDetail::find($booking->harga_detail_idharga_detail);

        $transaction_details = [
            'order_id' => $booking->transaksi_order_id,
            'gross_amount' => $booking->total_harga //berdasarkan total transaksi
        ];

        $customer_details = [
            'first_name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->nohp
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
            'quantity' => $booking->booking_jenis_trip == "open" ? $booking->booking_jmlh_penumpang : 1, 
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

        $transaction_data = array(
            'payment_type'          => 'vtweb', 
            'vtweb'                         => array(
                //'enabled_payments'    => [],
                'credit_card_3d_secure' => true
            ),
            'transaction_details'=> $transaction_details,
            'item_details'           => $item_details,
            'customer_details'   => $customer_details,
            'expiry' => $custom_expiry,
            'credit_card' => $credit_card_option,            
        );
        
        $vt = new Veritrans;

        try
        {
            $vtweb_url = $vt->vtweb_charge($transaction_data);
            return redirect($vtweb_url);
        } 
        catch (Exception $e) 
        {   
            return $e->getMessage;
        }

    }

    private function cekSlot($tanggal){
        $jmlDriver = Driver::count();
        $jmlSettlement = DB::table('booking')
            ->join('transaksi', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
            ->where('booking.booking_tgl_berangkat', '=', $tanggal)
            ->where('booking.booking_jenis_trip', '=', "open")
            ->where('transaksi.transaction_status', 'settlement')
            ->count();  
        $jmlCapture = DB::table('booking')
            ->join('transaksi', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
            ->where('booking.booking_tgl_berangkat', '=', $tanggal)
            ->where('booking.booking_jenis_trip', '=', "open")
            ->count();  
        $jmlPending = DB::table('booking')
            ->join('transaksi', 'booking.transaksi_order_id', '=', 'transaksi.order_id')
            ->where('booking.booking_tgl_berangkat', '=', $tanggal)
            ->where('booking.booking_jenis_trip', '=', "open")
            ->where('transaksi.transaction_status', 'pending')
            ->count();
        $jmlDriverOff = DriverOff::where('driver_off_tgl', $tanggal)->count();
        
        // selalu kurangi satu slot untuk cadangan
        $slot = $jmlDriver - $jmlSettlement - $jmlPending - $jmlCapture - $jmlDriverOff - 1;

        return $slot;
    }

}
