<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Client\SnapController;
use App\Models\Driver;
use App\Models\Booking;
use App\Models\DriverOff;
use App\Models\AntrianDriver;
use App\Models\HargaJemput;
use App\Models\HargaAntar;
use Illuminate\Support\Facades\Hash;
use DB;

class DriverController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:driver-api', ['except' => ['login']]);
    }

// - Login pada driver
//     + Post : Login
//     + request : username & password driver
//     + response : detail driver
//     * Proses :
//         - Validate username & password
//         - Cek username
//         - Cek password
//         - Get Data Driver

    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required'
        ]);

        // Get by username
        $driver = Driver::where('driver_username', $request->username)->first();

        if(empty($driver))
        {
            //if username == null
            return response()->json("Username tidak terdaftar");
        }elseif(Hash::check( $request->password, $driver->driver_password) == false)
        {
            //Password salah
            return response()->json("Password anda salah");
        }

        //Login benar
        return response()->json($driver);
    }

// - Memberikan notifikasi booking
//     + Post : Booking
//     + request : iddriver
//     + response : detail booking
//     * Proses :
//         - Get data booking yang antriannya belum ada konfirmasi
//         - Return data booking

    // Cek lagi setelah update
    public function booking(Request $request)
    {
        $antrianDrivers = AntrianDriver::with("Booking")->where("driver_iddriver", $request->iddriver)->where("antriandriver_status", "accepted")->where("antriandriver_status_baca", "belum")->get();

        $response = array();
        foreach ($antrianDrivers as $antriandriver) {
            if($antriandriver['booking'] != null){
                array_push($response, $antriandriver);
            }
        }

        if(empty($response)){
            return response()->json(null);
        }
        return response()->json($response);
    }

// - Menonaktifkan kesiapan driver
//     + Post : Off
//     + request : iddriver, tgl_off
//     + response : success
//     * Proses :
//         - Insert data driver dan tanggal ke tabel driver off
//         - return success

    // Status off gimana? dan method untuk hapus driver off gimana?
    public function off(Request $request)
    {
        $driverOff = new DriverOff();
        $driverOff->driver_off_tgl = date_create($request->tgl_off);
        $driverOff->driver_iddriver = $request->iddriver;
        $driverOff->save(); 

        return response()->json("Success");
    }

// - Menolak permintaan antrian
//     + Get : Decline
//     + response : success
//     * Proses :
//         - Get data antrian booking berdasarkan iddriver, idbooking
//         - Set statusAntrian decline
//         - Create data antrian baru menggunakan method findDriver
//         - Kirim email konfirmasi
//         - return data booking

    public function decline($idAntrianDriver)
    {
        $antrianDriver = AntrianDriver::findOrFail($idAntrianDriver);

        if(empty($antrianDriver)){
            return response()->json("No record data");
        }

        $idBooking = $antrianDriver->booking->idbooking;
        $antrianDriver->antriandriver_status = "decline";
        $antrianDriver->save();

        $snap = new SnapController;
        $snap->findDriver($antrianDriver->transaksi_order_id);
        $snap->sendEmail($antrianDriver->transaksi_order_id, "change");
        $booking = Booking::findOrFail($idBooking);
        
        return response()->json($booking);
    }

// - Show antrian driver from booking
//     + Post : antrian
//     + request : iddriver
//     + response : All detail antriandriver & booking
//     * Proses :
//         + Get data AntrianDriver & Booking by iddriver dan status antrian accept
//         + return data

    public function antrian(Request $request)
    {
        $data = AntrianDriver::with("Booking")->where("driver_iddriver",$request->iddriver)->where('antriandriver_status','accepted')->get();
        
        $response = array();
        foreach ($data as $antriandriver) {
            if($antriandriver['booking'] != null){
                array_push($response, $antriandriver);
            }
        }
        
        return response()->json($response);
    }

// - Show daftar tgl driver off
// 	+ Post : listdriveroff
// 	+ request : iddriver
// 	+ response : list driver_off
// 	+ Proses :
// 		+ Get data from driver_off by iddriver
// 		+ return data
    public function listDriverOff(Request $request){
        $data = DriverOff::where('driver_iddriver',$request->iddriver)->get();
        if($data){
            return response()->json($data);
        }
        
        return response()->json("Data not found");
    }

// - Delete tanggal driver off
// 	+ Post : deletedriveroff
// 	+ request : iddriver_off
// 	+ response : success
// 	+ proses : 
// 		+ Get data driver_off by iddriver_off from tabel driver_off
// 		+ Delete data
// 		+ return succes
    public function deletedDriverOff(Request $request){
        $data = DriverOff::findOrFail($request->iddriver_off);
        $data->delete();
        if($data){
            return response()->json("Succes");
        }
        
        return response()->json("Data not found");
    }

// - Api mengubah status notifikasi  antriandriver_status_baca
//     + Post : ubahstatusnotifikasi
//     + Request : idantriandriver
//     + Response : ubah antriandriver_status_baca menjadi "sudah"
//     + Proses : 
//         - Get data antrian by id antrian driver
//         - ubah antriandriver_status_baca menjadi "sudah"
//         - return success    
    public function ubahStatusNotifikasi(Request $request){
        $data = AntrianDriver::findOrFail($request->idantriandriver);
        
        if($data){
            $data->antriandriver_status_baca = "sudah";
            $data->save();
            return response()->json("Success");
        }

        return response()->json("Data not found");
    }
    
// - Api lokasi jemput
//     + Post : lokasijemput
//     + Request : idharga_jemput
//     + Response : details harga_jemput
//     + Proses : 
//         - get data harga_jemput by id harga jemput
//         - return data harga_jemput

    public function lokasijemput(Request $request){
        $data = HargaJemput::findOrFail($request->idharga_jemput);
        if($data){
            return response()->json($data);
        }
        
        return response()->json("Data not found");
    }
    
// - Api lokasi antar
//     + Post : lokasiantar
//     + Request : idharga_antar
//     + Response : details harga_antar
//     + Proses : 
//         - get data harga_antar by id harga antar
//         - return data harga_antar

    public function lokasiantar(Request $request){
        $data = HargaAntar::findOrFail($request->idharga_antar);
        if($data){
            return response()->json($data);
        }
        
        return response()->json("Data not found");
    }    
}
