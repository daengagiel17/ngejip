@extends('layouts.client')

@section('content')

    <div class="site-section bg-light">
      <div class="container">
        <div class="row" data-aos="fade">
         <div class="col-md-8 offset-md-2">
           <div class="job-post-item bg-white p-4 d-block d-md-flex align-items-center">

              <div class="mb-4 mb-md-0 mr-5">
               <div class="job-post-item-header d-flex align-items-center">
                 <h2 class="mr-3 text-black h4">Data Pesanan Anda</h2>
               </div>
               <div class="job-post-item-body d-block d-md-flex">
                 <div><span>Meliputi tanggal berangkat, jenis trip, paket trip, jumlah orang, dan status pembayaran.</span></div>
               </div>
              </div>
              {{-- <div class="ml-auto">
                  <a class="btn btn-primary py-2" href="#">Lihat Detail</a>
              </div> --}}
           </div>
         </div>
        </div>
        @if($bookings->isEmpty())
        <div class="row" data-aos="fade">
         <div class="col-md-8 offset-md-2">
           <div class="job-post-item bg-white p-4 d-block d-md-flex align-items-center">

              <div class="mb-4 mb-md-0 mr-5">
               <div class="job-post-item-header d-flex align-items-center">
                 <h2 class="mr-3 text-black h4">Tidak ada pesanan</h2>
               </div>
               <div class="job-post-item-body d-block d-md-flex">
                 <div><span>Maaf anda belum pernah melakukan pemesanan.</span></div>
               </div>
              </div>
              <div class="ml-auto">
                  <a class="btn btn-primary py-2" href="{{route('home')}}">Pesan Segera</a>
              </div>
           </div>
         </div>
        </div>
        @endif
        @foreach ($bookings as $booking)
        <div class="row" data-aos="fade">
         <div class="col-md-8 offset-md-2">
           <div class="job-post-item bg-white p-4 d-block d-md-flex align-items-center">

              <div class="mb-4 mb-md-0 mr-5">
               <div class="job-post-item-header d-flex align-items-center">
                 <h2 class="mr-3 text-black h4">{{\Carbon\Carbon::parse($booking->booking_tgl_berangkat)->format('d/m/Y')}}</h2>
               </div>
               <div class="job-post-item-body d-block d-md-flex">
                 <div><span>{{$booking->booking_jenis_trip}} trip | {{$booking->booking_paket_trip}} | {{$booking->booking_jmlh_penumpang}} Orang</span></div>
               </div>
              </div>
              <div class="ml-auto">
                  <span class="btn btn-warning py-2">{{$booking->booking_status_pembayaran}}</span>
                  <a class="btn btn-primary py-2" href="{{route('detail-pesanan', $booking->transaksi_order_id)}}">Lihat Detail</a>
              </div>
           </div>
         </div>
        </div>
        @endforeach
      </div>
    </div>    

@endsection