<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\AntrianDriver;
use App\Models\Driver;
use App\Models\Booking;
use App\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    // - Login Admin
	// + Post = 
	// + Request = username, password
	// + Response = detail admin
	// * Proses 
	// 	- Validate
	// 	- Get username
	// 	- Autentikasi
	// 	- return data admin
    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required'
        ]);

        // Get by username
        $admin = User::where('username', $request->username)->first();

        if(empty($admin))
        {
            //if username == null
            return response()->json("Username tidak terdaftar");
        }elseif(Hash::check( $request->password, $admin->password) == false)
        {
            //Password salah
            return response()->json("Password anda salah");
        }

        return response()->json($admin);
    }

// - Scan QR input date Start
// 	+ Post = start
// 	+ Request = barcode driver
// 	+ Response = change status
// 	* Proses 
// 		- Get data antriandriver by QR
// 		- Set datetime start di tabel antriandriver
// 		- Set status di tabel booking ready to otw 
// 		- return change status
    public function start(Request $request)
    {
        $antrian = AntrianDriver::where("antriandriver_qr",$request->qr)->first();
        if (empty($antrian)) {
            return response()->json("No record data");
        }elseif(empty($antrian->booking)){
            return response()->json("No booking data");
        }      
        $booking = Booking::findOrFail($antrian->booking->idbooking);
        $booking->booking_status = "otw";
        $booking->save();

        return response()->json("Status changed");
    }

// - Scan QR input date Finish
// 	+ Post = finish
// 	+ Request = barcode driver
// 	+ Response = change status
// 	* Proses 
// 		- Get data antriandriver by QR
// 		- Set datetime finish
// 		- Set status di tabel booking otw to finish 
// 		- return change status

    public function finish(Request $request)
    {
        $antrian = AntrianDriver::where("antriandriver_qr",$request->qr)->first();
        if (empty($antrian)) {
            return response()->json("No record data");
        }elseif(empty($antrian->booking)){
            return response()->json("No booking data");
        }     
        $booking = Booking::findOrFail($antrian->booking->idbooking);
        $booking->booking_status = "finish";
        $booking->save();

        return response()->json("Status changed");
    }

}
