<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//View Apps
Route::get('/apps-term',"Client\ViewAppsController@term")->name('term-apps');
Route::get('/apps-privacy',"Client\ViewAppsController@privacy")->name('privacy-apps');

// View Web
Route::get('/contact',"Client\ViewWebController@contact")->name('contact');
Route::get('/about',"Client\ViewWebController@about")->name('about');
Route::get('/privacy',"Client\ViewWebController@privacy")->name('privacy');
Route::get('/faq',"Client\ViewWebController@faq")->name('faq');
Route::get('/karir',"Client\ViewWebController@karir")->name('karir');
Route::get('/term',"Client\ViewWebController@term")->name('term');

// Auth OTP Customer
Route::get('login-otp/{state}',"Client\LoginOtpController@loginOtp")->name('login-otp');
Route::get('callback-otp',"Client\LoginOtpController@callbackOtp")->name('callback-otp');
Route::post('register-otp',"Client\LoginOtpController@registerOtp")->name('register-otp');
Route::post('logout-otp', "Client\LoginOtpController@logoutOtp")->name('logout-otp');

Route::get('tes',"Client\LoginOtpController@tes");
Route::get('register-form/{dataParam}',"Client\LoginOtpController@registerForm")->name('register-form');


// Proses booking
Route::get('/',"Client\BookingController@index")->name('home');
Route::post('/cek-harga',"Client\BookingController@cekHarga")->name('cek-harga');
Route::post('/cek-harga-private',"Client\BookingController@cekHargaPrivate")->name('cek-harga-private');
Route::post('/cek-harga-open',"Client\BookingController@cekHargaOpen")->name('cek-harga-open');
Route::post('/cek-harga',"Client\BookingController@cekHarga")->name('cek-harga');
Route::get('/list-harga/{idtransaksi}',"Client\BookingController@listHarga")->name('list-harga');
Route::post('/pesan',"Client\BookingController@pesan")->name('pesan');

// Cek Pesanan Midtrans 
Route::post('/notifikasi', 'Client\TransaksiController@notifikasi')->name('notifikasi');
Route::get('/list-pesanan', 'Client\TransaksiController@listPesanan')->name('list-pesanan');
Route::get('/detail-pesanan/{idtransaksi}', 'Client\TransaksiController@detailPesanan')->name('detail-pesanan');
Route::get('/pembayaran/finish',"Client\TransaksiController@finish")->name('finish');
Route::get('/pembayaran/unfinish',"Client\TransaksiController@unfinish")->name('unfinish');
Route::get('/pembayaran/error',"Client\TransaksiController@error")->name('error');

// Admin
Route::prefix('/admin')->group(function(){
	Route::get('/',"Admin\AdminController@index")->name('admin');
	Route::get('/thisMonth', "Admin\AdminController@thisMonth");

	Route::resource('/driver',"Admin\DriverController")->only([
		'index', 'store', 'destroy', 'show'
	]);
	Route::get('/driver-off', "Admin\DriverController@driverOff")->name('driver.off');

	Route::resource('/harga/antar',"Admin\HargaAntarController")->only([
		'index', 'store', 'destroy'
	]);

	Route::resource('/harga/jemput',"Admin\HargaJemputController")->only([
		'index', 'store', 'destroy'
	]);

	Route::resource('/harga/tiket',"Admin\HargaTiketController")->only([
		'index', 'store', 'destroy'
	]);

	Route::resource('/harga/jeep-changed',"Admin\JeepChangedController")->only([
		'index', 'store', 'destroy'
	]);

	Route::resource('/harga/jeep-default',"Admin\JeepDefaultController")->only([
		'index', 'store', 'destroy'
	]);	

	// Data Transaksi
	Route::prefix('/transaksi')->group(function(){
		Route::get('/',"Admin\TransaksiController@index")->name('transaksi.index');
		Route::get('/settlement',"Admin\TransaksiController@settlement")->name('transaksi.settlement');
		Route::get('/expire',"Admin\TransaksiController@expire")->name('transaksi.expire');
		Route::get('/failure',"Admin\TransaksiController@failure")->name('transaksi.failure');
		Route::get('/pending',"Admin\TransaksiController@pending")->name('transaksi.pending');
		Route::get('/cancel',"Admin\TransaksiController@cancel")->name('transaksi.cancel');	
	});

	// Data Booking
	Route::prefix('/booking')->group(function(){
		Route::get('/',"Admin\BookingController@index")->name('booking.index');
		Route::get('/cek',"Admin\BookingController@cek")->name('booking.cek');
		Route::get('/pesan',"Admin\BookingController@pesan")->name('booking.pesan');
		Route::get('/pembayaran',"Admin\BookingController@pembayaran")->name('booking.pembayaran');
		Route::get('/lunas',"Admin\BookingController@lunas")->name('booking.lunas');
	});

	// Data Antrian 
	Route::prefix('/antrian')->group(function(){
		Route::get('/',"Admin\AntrianController@index")->name('antrian.index');
		Route::get('/accept',"Admin\AntrianController@accept")->name('antrian.accept');
		Route::get('/decline',"Admin\AntrianController@decline")->name('antrian.decline');
		Route::get('/off',"Admin\AntrianController@off")->name('antrian.off');
	});

	// Data Trip yang sudah sukses transaksi 
	Route::prefix('/trip')->group(function(){
		Route::get('/',"Admin\TripController@index")->name('trip.index');
		Route::get('/show/{order_id}',"Admin\TripController@show")->name('trip.show');
		Route::get('/date/{tanggal}',"Admin\TripController@byDate")->name('trip.date');
		Route::get('/ready',"Admin\TripController@ready")->name('trip.ready');
		Route::get('/otw',"Admin\TripController@otw")->name('trip.otw');
		Route::get('/finish',"Admin\TripController@finish")->name('trip.finish');
	});

	// Auth Admin
	Route::get('login', 'Auth\LoginAdminController@login')->name('login');
	Route::post('login', 'Auth\LoginAdminController@loginAdmin');
	Route::post('logout', 'Auth\LoginAdminController@logout')->name('logout');

});

// Simulasi Midtrans
Route::get('/vtweb', 'VtwebController@vtweb')->name('pesanaja');

Route::get('/vtdirect', 'VtdirectController@vtdirect');
Route::post('/vtdirect', 'VtdirectController@checkout_process');

Route::get('/vt_transaction', 'TransactionController@transaction');
Route::post('/vt_transaction', 'TransactionController@transaction_process');

Route::post('/vt_notif', 'VtwebController@notification');

Route::get('/snap', 'SnapController@snap');
Route::get('/snaptoken', 'SnapController@token');
Route::post('/snapfinish', 'SnapController@finish');

// Saat production untuk penangan URL error
// Route::any('{all}', function(){
//     return abort('404');
// })->where('all', '.*');