<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\AntrianDriver;
use App\Models\Driver;
use App\Models\DriverOff;
use App\Models\Transaksi;
use Midtrans;
use Veritrans;
use Redirect;
use DB;
use Mail;
use Auth;

class TransaksiController extends Controller
{
    // Ini endpoint yang diperlukan Midtrans berupa notifikasi, finish, unfinish, error
    public function notifikasi(Request $request)
    {
        if($request){
            $notif = Midtrans::status($request->order_id);
            $transaksi = Transaksi::find($notif->transaction_id);
            $booking = Booking::where('transaksi_order_id', $request->order_id)->first();

            if($transaksi == null){
                $transaksi = new Transaksi();
                $transaksi->transaction_id = $notif->transaction_id;
                $transaksi->transaction_time = date($notif->transaction_time);
                $transaksi->transaction_status = $notif->transaction_status;
                $transaksi->status_message = $notif->status_message;
                $transaksi->signature_key = $notif->signature_key;
                $transaksi->payment_type = $notif->payment_type;
                $transaksi->order_id = $notif->order_id;
                $transaksi->gross_amount = $notif->gross_amount;
                $transaksi->save();

                if($transaksi->transaction_status == "pending" && $booking->booking_status_pembayaran = "pesan"){
                    $booking->booking_status_pembayaran = "pembayaran";
                    $booking->save();    
                }

                // Belum tau perubahan status setelah di approve, status pembayaran masih pesan
                if($notif->payment_type == "credit_card" && $notif->fraud_status == "challenge"){
                    Veritrans::approve($notif->order_id);
                    $booking->booking_status_pembayaran = "pembayaran";
                    $booking->save();    
                }
    
            }else{
                // Akan ada banyak status yg dikirim oleh midtrans selain pending, settlement, expire, cancel
                $transaksi->transaction_status = $notif->transaction_status;
                $transaksi->status_message = $notif->status_message;
                $transaksi->save();

                // Mengubah status pembayaran jadi lunas berdasarkan status transaksi yg sebelumnya pending bukan settlement
                // Mencari driver ketika telah selesai transaksi lalu mengirimkan email
                if($transaksi->transaction_status == "settlement" && $booking->booking_status_pembayaran == "pembayaran"){
                    $booking->booking_status_pembayaran = "lunas";
                    $booking->save();
        
                    $this->findDriver($notif->order_id);
                    $this->sendEmail($notif->order_id, "new");
                }elseif($transaksi->transaction_status == "expire"){
                    $booking->booking_status_pembayaran = "expire";
                    $booking->save();
                }elseif($transaksi->transaction_status == "deny"){
                    $booking->booking_status_pembayaran = "ditolak";
                    $booking->save();
                }            }

            return response()->json(['success' => "200"]);
        }

        error_log(print_r($result,TRUE));
        return response()->json(['error' => "400"]);      
    }

    public function finish(Request $request)
    {
        return redirect()->route('detail-pesanan', $request->order_id);
    }

    public function unfinish()
    {
        return redirect()->route('home')->with('danger', 'Transaksi tidak selesai, mohon hubungi customer service kami untuk penanganan masalah ini');   
    }

    public function error()
    {
        return redirect()->route('home')->with('danger', 'Tejadi kesalahan, mohon hubungi customer service kami untuk penanganan masalah ini');   
    }

    // Ini untuk melihat data pesanan customer
    public function listPesanan()
    {
        if (!Auth::check()) {
            return redirect()->route('login-otp', ['state' => "list-pesanan"]);            
        }

        $bookings = Booking::where('user_id', Auth::id())->get();

        return view('client/list-pesanan', compact('bookings'));
    }

    public function detailPesanan($idorder)
    {
        if (!Auth::check()) {
            return redirect()->route('login-otp', ['state' => "list-pesanan"]);            
        }

        // Get data status transaksi
        $transaksi = Midtrans::status($idorder);
        $booking = Booking::where('transaksi_order_id', $idorder)->first();
        $transaction = $transaksi->transaction_status;
        $type = $transaksi->payment_type;
        $order_id = $transaksi->order_id;

        // jika status masih capture dan khusus pembayaran credit card
        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card'){
                $fraud = $transaksi->fraud_status;
                if($fraud == 'challenge'){
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    // echo "Transaction order_id: " . $order_id ." is challenged by FDS";
                    $pesan = "Transaction order_id: " . $order_id ." is challenged by FDS";
                    return view('client/detail-pesanan', compact('transaksi','booking','pesan'));
                } 
                else {
                    // TODO set payment status in merchant's database to 'Success'
                    // echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;                    
                    $pesan = "Transaction order_id: " . $order_id ." successfully captured using " . $type
                            . ". Kami menunggu status settlement untuk memproses pemesanan anda. Mohon cek pemesanan dan email anda secara berkala.";
                    return view('client/detail-pesanan', compact('transaksi','booking','pesan'));    
                }
            }

        }
        // transaksi telah dibayar
        else if ($transaction == 'settlement'){
            // TODO set payment status in merchant's database to 'Settlement'
            // echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
            $antrianDriver = AntrianDriver::where('transaksi_order_id', $order_id)->first();
            $driver = $antrianDriver->driver;
            $pesan = "Terima kasih telah melakulan pembayaran. Silahkan hubungi driver kami";
            return view('client/detail-pesanan', compact('transaksi','booking','driver','pesan'));    
        }
        // transaksi di pending belum dibayar
        else if($transaction == 'pending'){
            // TODO set payment status in merchant's database to 'Pending'
            // echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
            $pesan = "Anda belum melakukan pembayaran. Mohon tunggu beberapa saat setelah pembayaran, pembayaran anda sedang diverifikasi";
            return view('client/detail-pesanan', compact('transaksi','booking','pesan')); 
        } 
        // transaksi bermasalah
        else if ($transaction == 'deny') {
            // dd("Deny",$transaksi);
            // TODO set payment status in merchant's database to 'Denied'
            // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
            $pesan = "Pesanan ditolak harap hubungi customer service kami";
            return view('client/detail-pesanan', compact('transaksi','booking','pesan')); 
        }
        // transaksi expire
        else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'Denied'
            // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
            $pesan = "Pesanan dibatalkan karena melewati batas waktu pembayaran";
            return view('client/detail-pesanan', compact('transaksi','booking','pesan')); 
        }

        $pesan = "Ada kesalahan mohon hubungi customer service kami";
        return view('client/detail-pesanan', compact('transaksi','booking','pesan'));         

    }

    // Untuk menemukan driver
    public function findDriver($order_id)
    {
        // Find booking by id order
        $booking = Booking::where('transaksi_order_id', $order_id)->first();

        if($booking->booking_jenis_trip == "open"){
            $driver = Driver::where('driver_username', "cadangan")->first();
            $driver->driver_jmlh_orderan++;
            $driver->save();
            
            $antriandriver = new AntrianDriver;
            $antriandriver->antriandriver_status = "accepted";
            $antriandriver->antriandriver_status_baca = "belum";
            $antriandriver->antriandriver_qr = uniqid();
            $antriandriver->driver_iddriver = $driver->iddriver;
            $antriandriver->transaksi_order_id = $booking->transaksi_order_id;
            $antriandriver->save();
            
            return;
        }

        // Find Driver. Default nilai false
        $find = false;
        $driver_temp = array();
        while(!$find){
            // Cari driver yang jumlah order terendah
            $driver = Driver::orderBy('driver_jmlh_orderan')->whereNotIn('iddriver', $driver_temp)
            ->whereNotIn('driver_username', ["cadangan"])->first();
            
            // Jika driver sdh keluar semua maka pesan driver cadangan
            if($driver == null){
                $driver = Driver::where('driver_username', "cadangan")->first();
                $driver->driver_jmlh_orderan++;
                $driver->save();
                
                $antriandriver = new AntrianDriver;
                $antriandriver->antriandriver_status = "accepted";
                $antriandriver->antriandriver_status_baca = "belum";
                $antriandriver->antriandriver_qr = uniqid();
                $antriandriver->driver_iddriver = $driver->iddriver;
                $antriandriver->transaksi_order_id = $booking->transaksi_order_id;
                $antriandriver->save();
                
                $find = true;                
            }

            // Cek driver off atau tidak 
            $driver_off = DriverOff::where("driver_iddriver", $driver->iddriver)
                ->where("driver_off_tgl", $booking->booking_tgl_berangkat)
                ->first();
                
            // Cek driver telah ada di antrian atau tidak
            $cekAntrian = AntrianDriver::where('transaksi_order_id', $order_id)
                ->where('driver_iddriver', $driver->iddriver)
                ->first();

            // Cek driver telah accepted antrian atau tidak
            $cekAccepted = DB::table('driver')
                ->join('antriandriver', 'antriandriver.driver_iddriver', '=', 'driver.iddriver')
                ->join('booking', 'antriandriver.transaksi_order_id', '=', 'booking.transaksi_order_id')
                ->where('booking.booking_tgl_berangkat', $booking->booking_tgl_berangkat)
                ->where('antriandriver.antriandriver_status', 'accepted')
                ->where('driver.iddriver', $driver->iddriver)
                ->first();                 

                // Jika driver off jmlh orderan tetap ditambah lalu berulang mencari driver lain
            if($driver_off){
                $driver->driver_jmlh_orderan++;
                $driver->save();

                $antriandriver = new AntrianDriver;
                $antriandriver->antriandriver_status = "driver_off";
                $antriandriver->antriandriver_status_baca = "belum";
                $antriandriver->antriandriver_qr = uniqid();
                $antriandriver->driver_iddriver = $driver->iddriver;
                $antriandriver->transaksi_order_id = $booking->transaksi_order_id;
                $antriandriver->save();
                
            // Jika tidak ada antrian maka masuk dalam daftar antrian
            }elseif($cekAntrian == null && $cekAccepted == null){
                $driver->driver_jmlh_orderan++;
                $driver->save();

                $antriandriver = new AntrianDriver;
                $antriandriver->antriandriver_status = "accepted";
                $antriandriver->antriandriver_status_baca = "belum";
                $antriandriver->antriandriver_qr = uniqid();
                $antriandriver->driver_iddriver = $driver->iddriver;
                $antriandriver->transaksi_order_id = $booking->transaksi_order_id;
                $antriandriver->save();
                
                $find = true;
            }
            $driver_temp[] = $driver->iddriver;        
        }       
    }    

    // Mengirim email ke customer berdasarkan order id dan statusnya
    public function sendEmail($order_id, $status)
    {
        $antriandriver = AntrianDriver::where('transaksi_order_id', $order_id)->where('antriandriver_status', 'accepted')->first();
        $booking = Booking::where('transaksi_order_id', $order_id)->first();
        $driver = Driver::findOrFail($antriandriver->driver_iddriver);             

        $data = [
            'nama_customer' => $booking->booking_nama,
            'tgl_berangkat' => date('d F Y', strtotime($booking->booking_tgl_berangkat)),
            'lokasi_jemput' => $booking->hargajemput->harga_jemput_lokasi,
            'lokasi_antar' => $booking->hargaantar->harga_antar_lokasi,
            'nama_driver' => $driver->driver_nama,
            'no_hp_driver' => $driver->driver_nohp
        ];

        $email = $booking->booking_email;

        if($status == "change"){
            try{
                Mail::send('email decline', compact('data') , function ($message) use($email) 
                {
                    $message->subject("New Driver ngeJIP");
                    $message->from('kontak@ngejip.site', 'Support ngeJIP');
                    $message->to($email);
                });
            }
            catch (Exception $e){
                return response (['status' => false,'errors' => $e->getMessage()]);
            }               
        }elseif($status == "new"){
            try{
                Mail::send('email', compact('data'), function ($message) use($email) 
                {
                    $message->subject("Driver ngeJIP");
                    $message->from('kontak@ngejip.site', 'Support ngeJIP');
                    $message->to($email);
                });
            }
            catch (Exception $e){
                return response (['status' => false,'errors' => $e->getMessage()]);
            }    
        }
    }
}