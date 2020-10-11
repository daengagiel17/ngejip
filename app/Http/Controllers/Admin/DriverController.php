<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Booking;
use App\Models\AntrianDriver;
use App\Models\DriverOff;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
    	$drivers = Driver::all();
        return view("admin.kelola driver.daftar driver", compact('drivers'));
    }

    public function store(Request $request)
    {
        $driver = new Driver;
        $driver->driver_nama = $request->nama_driver;
        $driver->driver_username = $request->username_driver;
        $driver->driver_nohp = "+62".substr($request->nohp_driver,1);
        $driver->driver_jmlh_orderan = Driver::min('driver_jmlh_orderan');
        $driver->password = bcrypt($driver->driver_nohp);
        $driver->api_token = str_random(100);
        $driver->save();

        return redirect()->route('driver.index');
    }

    public function show($id)
    {
        $driver = Driver::findOrFail($id);
        $antrians = $driver->antrianDriver;
        // dd($antrians);
        return view("admin.kelola driver.detail driver", compact('driver','antrians'));
    }

    public function driverOff()
    {
        $driversOff = DriverOff::all();

        return view("admin.kelola driver.driver off", compact('driversOff'));
    }

    public function destroy($id)
    {  
       $driver = Driver::findOrFail($id);
       $driver->delete();

        return response()->json($driver);
    }

}
