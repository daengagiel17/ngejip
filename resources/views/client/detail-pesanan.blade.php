@extends('layouts.client')

@section('content')
    <div class="py-5 bg-primary">
      <div class="container"> 
        <div class="row row-custom align-items-center">
          <div class="col-md-1"></div>
          <div class="col-md-10">
            @if (\Session::has('danger'))
              <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <strong>Mohon maaf !</strong> {!! \Session::get('danger') !!}
              </div>
            @endif
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 offset-md-1"> 
              {{-- <h2 class="font-weight-bold text-white">Input Data Pesanan</h2> 
              <form action="{{ route('cek-pesanan') }}" method="post">
                {{ csrf_field() }}   
                <input type="text" name="order_id" class="form-control" value="{{$transaksi->order_id}}" placeholder="Masukkan id order" required><br>
                <input type="email" name="email_pemesan" class="form-control" value="{{$booking->booking_email}}" placeholder="Masukkan email" required><br>
                <button type="submit" class="btn btn-dark btn-block" style="height: 45px;">Cek Pesanan</button>
              </form> --}}
          </div>
          <div class="col-md-6">
            <h2 class="text-white h4 font-weihgt-normal mb-3">Data Booking</h2>
              <div class="bg-white p-4 rounded mb-3">
                <p class="mb-0"><span class="font-weight-bold">Waktu Pesan</span> 
                  {{\Carbon\Carbon::parse($transaksi->transaction_time)->format('H:i:s')}}
                </p>
                <p class="mb-0"><span class="font-weight-bold">Tanggal Trip</span> 
                  {{\Carbon\Carbon::parse($booking->booking_tgl_berangkat)->format('d/m/Y')}}
                </p>
                <p class="mb-0"><span class="font-weight-bold">Jenis Trip </span> Sunrise</p>
                <p class="mb-0"><span class="font-weight-bold">Jumplah Penumpang </span> {{$booking->booking_jmlh_penumpang}} Orang</p><hr>
                @if ($transaksi->transaction_status=="settlement")
                  <h5> Identitas Driver :</h5>
                  <p class="mb-0"><span class="font-weight-bold">Nama Driver</span> {{$driver->driver_nama}}</p>
                  <p class="mb-0"><span class="font-weight-bold">Nomor Handphone</span> {{$driver->driver_nohp}}</p>
                  <p class="mb-0 center"> 
                      <a href="https://wa.me/{{$driver->driver_nohp}}?text=Saya%20{{$booking->booking_nama}}%20telah%20memesan%20jeep%20melalui%20aplikasi%20ngeJIP" target="_blank" class="btn btn-sm btn-dark">
                        <span class="icon-whatsapp"></span> Hubungi Driver
                      </a>
                  </p><hr>
                @endif          
                <p class="mb-0"><span class="font-weight-bold">{{$pesan}}</span></p>   
              </div>
          </div>
        </div>            
      </div>
    </div>
@endsection