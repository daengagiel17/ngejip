<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HargaJemput;

class HargaJemputController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
        
    public function index()
    {
    	$hargaJemputs = HargaJemput::all();
        return view("admin.kelola harga.harga jemput", compact('hargaJemputs'));
    }

    public function store(Request $request)
    {        
        $hargaJemput = new HargaJemput;
        $hargaJemput->harga_jemput_lokasi = $request->harga_jemput_lokasi;
        $hargaJemput->harga_jemput_nominal = $request->harga_jemput_nominal;
        $hargaJemput->harga_jemput_pertgl = $request->harga_jemput_pertgl;
        $hargaJemput->harga_jemput_status = "on";
        $hargaJemput->save();
        return redirect()->route('jemput.index');
    }

    public function destroy($id)
    {
        $hargaJemput = HargaJemput::findOrFail($id);
        $hargaJemput->delete();
        return response()->json($hargaJemput);
    }

}
