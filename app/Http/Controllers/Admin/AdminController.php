<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Transaksi;
use App\Models\AntrianDriver;
use App\Models\Admin;
use DB;
use Auth;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $booking =  Booking::where('booking_status_pembayaran', 'lunas')->get();
        $jmlh_booking = $booking->count();
        $jmlh_driver = Driver::count();
        $trip_today = $booking->where('booking_tgl_berangkat', date('Y-m-d 00:00:00'))->count();
        $trip_tomorrow = $booking->where('booking_tgl_berangkat', date('Y-m-d 00:00:00',strtotime("tomorrow")))->count();

        return view("admin.dashboard", compact('jmlh_booking','jmlh_driver', 'trip_today', 'trip_tomorrow'));
    }

    public function thisMonth(){
        $booking =  Booking::where('booking_status', 'finish')->get();
        $hari = array();
        $trip = array();
        $transaksi = array();
        $tanggal = date('d');
        for($i=0 ; $i<$tanggal ; $i++){
            $interval = $tanggal-($i+1);
            $hari[] = $i+1;             
            $trip[] = $booking->where('booking_tgl_berangkat', date('Y-m-d 00:00:00', strtotime('-'.$interval.' days')))
                ->where('booking_status', 'finish')
                ->count();
            $transaksi[] = DB::table('transaksi')
                            ->where('transaction_status', 'settlement')
                            ->whereDate('updated_at', date('Y-m-d 00:00:00', strtotime('-'.$interval.' days')))->count();
        }
        $data = ['tanggal' => $hari, 'trip' => $trip, 'booking' => $transaksi];
        
        return response()->json($data);
    }

}
