<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HargaJeepChanged;

class JeepChangedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
        
    public function index()
    {
    	$hargaJeepChangeds = HargaJeepChanged::all();
        return view("admin.kelola harga.jeep changed", compact('hargaJeepChangeds'));
    }

    public function store(Request $request)
    {        
        $hargaJeepChanged = new HargaJeepChanged;
        $hargaJeepChanged->harga_jeep_changed_nominal = $request->harga_jeep_changed_nominal;
        $hargaJeepChanged->harga_jeep_changed_tgl_start = $request->harga_jeep_changed_tgl_start;
        $hargaJeepChanged->harga_jeep_changed_tgl_finish = $request->harga_jeep_changed_tgl_finish;
        $hargaJeepChanged->save();

        return redirect()->route('jeep-changed.index');
    }

    public function destroy($id)
    {
        $hargaJeepChanged = HargaJeepChanged::findOrFail($id);
        $hargaJeepChanged->delete();

        return response()->json($hargaJeepChanged);
    } 
}
