<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AntrianDriver;

class AntrianController extends Controller
{
    public function __construct()
    {
        // Konsep auth admin dan driver
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        $antrian = AntrianDriver::all();

        $jmlh_accept = $antrian->where('antriandriver_status','accepted')->count();
        $jmlh_decline = $antrian->where('antriandriver_status','decline')->count();
        $jmlh_off = $antrian->where('antriandriver_status','off')->count();

        return view("admin.kelola antrian.daftar antrian", compact('antrian','jmlh_accept','jmlh_decline','jmlh_off'));
    }

    public function accept()
    {
        $antrian = AntrianDriver::where('antriandriver_status', 'accepted')->get();
        return view("admin.kelola antrian.antrian accept", compact('antrian'));
    }

    public function decline()
    {
        $antrian = AntrianDriver::where('antriandriver_status', 'decline')->get();
        return view("admin.kelola antrian.antrian decline", compact('antrian'));
    }

    public function off()
    {
        $antrian = AntrianDriver::where('antriandriver_status', 'off')->get();
        return view("admin.kelola antrian.antrian off", compact('antrian'));
    }
}
