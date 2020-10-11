<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HargaJeepDefault;

class JeepDefaultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
    	$hargaJeepDefaults = HargaJeepDefault::all();
        return view("admin.kelola harga.jeep default", compact('hargaJeepDefaults'));
    }

    public function store(Request $request)
    {              
        $hargaJeepDefault = new HargaJeepDefault;
        $hargaJeepDefault->harga_jeep_default_nominal = $request->harga_jeep_default_nominal;
        $hargaJeepDefault->harga_jeep_default_pertanggal = $request->harga_jeep_default_pertanggal;
        $hargaJeepDefault->harga_jeep_default_status = "on";
        $hargaJeepDefault->save();

        return redirect()->route('jeep-default.index');
    }

    public function destroy($id)
    {
        $hargaJeepDefault = HargaJeepDefault::findOrFail($id);
        $hargaJeepDefault->delete();

        return response()->json($hargaJeepDefault);
    } 
}
