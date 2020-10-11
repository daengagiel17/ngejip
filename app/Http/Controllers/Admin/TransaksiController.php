<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
        
    public function index()
    {
    	$transaksis = Transaksi::all();
    	$jmlh_settlement = $transaksis->where('transaction_status','settlement')->count();
    	$jmlh_expire = $transaksis->where('transaction_status','expire')->count();
       	$jmlh_cancel = $transaksis->where('transaction_status','cancel')->count();
    	$jmlh_failure = $transaksis->where('transaction_status','failure')->count();
    	$jmlh_pending = $transaksis->where('transaction_status','pending')->count();
        return view("admin.kelola transaksi.daftar transaksi", compact('transaksis','jmlh_settlement','jmlh_pending' ,'jmlh_failure','jmlh_cancel','jmlh_expire'));
    }

    public function settlement()
    {
    	$transaksis = Transaksi::where('transaction_status','settlement')->get();
    	$jumlah = $transaksis->count();
    	$total = $transaksis->sum('gross_amount');
        return view("admin.kelola transaksi.transaksi settlement", compact('transaksis','jumlah', 'total'));
    }

    public function pending()
    {
    	$transaksis = Transaksi::where('transaction_status','pending')->get();
    	$jumlah = $transaksis->count();
    	$total = $transaksis->sum('gross_amount');
        return view("admin.kelola transaksi.transaksi pending", compact('transaksis','jumlah', 'total'));
    }

    public function cancel()
    {
    	$transaksis = Transaksi::where('transaction_status','cancel')->get();
    	$jumlah = $transaksis->count();
    	$total = $transaksis->sum('gross_amount');
        return view("admin.kelola transaksi.transaksi cancel", compact('transaksis','jumlah', 'total'));
    }   

    public function failure()
    {
    	$transaksis = Transaksi::where('transaction_status','failure')->get();
    	$jumlah = $transaksis->count();
    	$total = $transaksis->sum('gross_amount');
        return view("admin.kelola transaksi.transaksi failure", compact('transaksis','jumlah', 'total'));
    }

    public function expire()
    {
    	$transaksis = Transaksi::where('transaction_status','expire')->get();
    	$jumlah = $transaksis->count();
    	$total = $transaksis->sum('gross_amount');
        return view("admin.kelola transaksi.transaksi expire", compact('transaksis','jumlah', 'total'));
    } 
}
