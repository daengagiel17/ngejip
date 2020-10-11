<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HargaTiket;

class HargaTiketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
        
    public function index()
    {
        $hargaTikets = HargaTiket::all();
        return view("admin.kelola harga.harga tiket", compact('hargaTikets'));
    }

    public function store(Request $request)
    {        
        $hargaTiket = new HargaTiket;
        $hargaTiket->harga_tiket_weekend = $request->harga_tiket_weekend;
        $hargaTiket->harga_tiket_weekday = $request->harga_tiket_weekday;
        $hargaTiket->harga_tiket_pertanggal = $request->harga_tiket_pertanggal;
        $hargaTiket->harga_tiket_status = "on";
        $hargaTiket->save();

        return redirect()->route('tiket.index');
    }

    public function destroy($id)
    {
        $hargaTiket = HargaTiket::findOrFail($id);
        $hargaTiket->delete();

        return response()->json($hargaTiket);
    }   
}
