<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HargaAntar;

class HargaAntarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
        
    public function index()
    {
        $hargaAntars = HargaAntar::all();
        return view("admin.kelola harga.harga antar", compact('hargaAntars'));
    }

    public function store(Request $request)
    {        
        $hargaAntar = new HargaAntar;
        $hargaAntar->harga_antar_lokasi = $request->harga_antar_lokasi;
        $hargaAntar->harga_antar_nominal = $request->harga_antar_nominal;
        $hargaAntar->harga_antar_pertgl = $request->harga_antar_pertgl;
        $hargaAntar->harga_antar_status = "on";
        $hargaAntar->save();
        return redirect()->route('antar.index');
    }

    public function destroy($id)
    {
        $hargaAntar = HargaAntar::findOrFail($id);
        $hargaAntar->delete();
        return response()->json($hargaAntar);
    }
 
}
