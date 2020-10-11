<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/driver')->group(function(){
	Route::post('/login', 'Api\DriverController@login');
	Route::post('/booking','Api\DriverController@booking');
	Route::post('/off','Api\DriverController@off');
	Route::get('/decline/{idantriandriver}','Api\DriverController@decline');
	Route::post('/antrian','Api\DriverController@antrian');
	Route::post('/ubahstatusnotifikasi','Api\DriverController@ubahStatusNotifikasi');
	Route::post('/deleteddriveroff','Api\DriverController@deletedDriverOff');
	Route::post('/listdriveroff','Api\DriverController@listDriverOff');
	Route::post('/lokasijemput','Api\DriverController@lokasijemput');
	Route::post('/lokasiantar','Api\DriverController@lokasiantar');
});

Route::prefix('/portal')->group(function(){
	Route::post('/login', 'Api\AdminController@login');
	Route::post('/start','Api\AdminController@start');
	Route::post('/finish','Api\AdminController@finish');
});

Route::prefix('/client')->group(function(){
	Route::post('/cek-harga', 'Api\ClientController@cekHarga');
	Route::post('/pesan', 'Api\ClientController@pesan');
	Route::post('/bayar', 'Api\ClientController@bayar');
	Route::post('/cek-pesanan', 'Api\ClientController@cekPesanan');

	Route::get('/akun/{nohp}', 'Api\Client\ClientController@getAccount');
	Route::post('/akun', 'Api\Client\ClientController@setAccount');
	Route::post('/cek-harga-private', 'Api\Client\ClientController@getHargaPrivate');
	Route::post('/cek-harga-open', 'Api\Client\ClientController@getHargaOpen');
	Route::get('/booking/{idorder}', 'Api\Client\ClientController@setBooking');
	Route::get('/daftar-booking', 'Api\Client\ClientController@getBookings');
	Route::get('/detail-booking/{idorder}', 'Api\Client\ClientController@getDetailBooking');
});
