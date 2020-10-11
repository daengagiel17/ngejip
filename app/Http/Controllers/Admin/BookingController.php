<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
        
    public function index()
    {
        $booking = Booking::all();
        $jmlh_cek = $booking->where('booking_status_pembayaran', 'cek')->count();
        $jmlh_pesan = $booking->where('booking_status_pembayaran', 'pesan')->count();
        $jmlh_pembayaran = $booking->where('booking_status_pembayaran', 'pembayaran')->count();
        $jmlh_lunas = $booking->where('booking_status_pembayaran', 'lunas')->count();
        return view("admin.kelola booking.daftar booking", compact('booking','jmlh_cek','jmlh_pesan','jmlh_pembayaran','jmlh_lunas'));
    }

    public function cek()
    {
        $booking = Booking::where('booking_status_pembayaran', 'cek')->get();
        return view("admin.kelola booking.booking cek", compact('booking'));
    }

    public function pesan()
    {
        $booking = Booking::where('booking_status_pembayaran', 'pesan')->get();
        return view("admin.kelola booking.booking pesan", compact('booking'));
    }

    public function pembayaran()
    {
        $booking = Booking::where('booking_status_pembayaran', 'pembayaran')->get();
        return view("admin.kelola booking.booking pembayaran", compact('booking'));
    }

    public function lunas()
    {
        $booking = Booking::where('booking_status_pembayaran', 'lunas')->get();
        return view("admin.kelola booking.booking lunas", compact('booking'));
    }


}
