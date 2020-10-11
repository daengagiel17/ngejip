<?php

use Illuminate\Database\Seeder;
use App\Models\Transaksi;

class TransaksiSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transaksi = new Transaksi;
        $transaksi->transaction_id = "a854d0ca-16e1-41f1-9129-8a50550148a7";
        $transaksi->transaction_time = date("2018-12-26 07:56:39");
        $transaksi->transaction_status = "success";
        $transaksi->status_message = "midtrans payment notification";
        $transaksi->signature_key = "c69d78da0b64e999aedb597491a36a97bfe85ca4863eb7e3079d4caa8b909a3ebdcc0b5f07c8199a25a27680c85aa59e34d4fcec633048a4f61dfd7559eb29ce";
        $transaksi->payment_type = "cstore";
        $transaksi->order_id = "1545785766";
        $transaksi->gross_amount = 170000;
        $transaksi->save();

        $transaksi = new Transaksi;
        $transaksi->transaction_id = "992e934f-bf5b-4254-98da-f25bb92a62bb";
        $transaksi->transaction_time = date("2018-12-25 14:31:22");
        $transaksi->transaction_status = "success";
        $transaksi->status_message = "midtrans payment notification";
        $transaksi->signature_key = "fb20c5f27a90be94c3ae222d4e10bfb21961c6e0847bdb25fde11ce0a7d064ea3026065c00bf1074cf3fd7759b51d355ed16d353402c1d31adaeae5de3114e73";
        $transaksi->payment_type = "cstore";
        $transaksi->order_id = "1545723022";
        $transaksi->gross_amount = 10000;
        $transaksi->save();
    }
}
