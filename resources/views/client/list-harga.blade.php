@extends('layouts.client')

@section('content')

    <div class="site-section bg-light">
      <div class="container">
        <div class="row" data-aos="fade">
         <div class="col-md-8 offset-md-2">
           <div class="job-post-item bg-white p-4 d-block d-md-flex align-items-center">

              <div class="mb-4 mb-md-0 mr-5">
               <div class="job-post-item-header d-flex align-items-center">
                 <h2 class="mr-3 text-black h4">Harga Total</h2>
               </div>
               <div class="job-post-item-body d-block d-md-flex">
                 <div><span class="fl-bigmug-line-big104"></span> <span>Sudah termasuk harga jemput, harga antar, dan harga tiket</span></div>
               </div>
              </div>

              <div class="ml-auto">
                <h2 class="mr-3 text-black h4">{{$booking->total_harga}}</h2>
              </div>
           </div>

         </div>
        </div>

        <div class="row" data-aos="fade">
         <div class="col-md-8 offset-md-2">
           <div class="job-post-item bg-white p-4 d-block d-md-flex align-items-center">

              <div class="mb-4 mb-md-0 mr-5">
               <div class="job-post-item-header d-flex align-items-center">
                 <h2 class="mr-3 text-black h4">Harga Detail</h2>
               </div>
               <div class="job-post-item-body d-block d-md-flex">
                 <div>
                    <span class="fl-bigmug-line-big104"></span> <span>Sewa Jeep</span><br>
                    @if ($booking->booking_jenis_trip == "private")
                      <span>Rp. {{$harga_detail->harga_detail_jeep}}</span><br>
                    @else
                      <span>Rp. {{$harga_detail->harga_detail_jeep}} x {{$booking->booking_jmlh_penumpang}} orang</span><br>
                    @endif
                    <span class="fl-bigmug-line-big104"></span> <span>Jemput dari {{$booking->booking_lokasi_jemput}}</span><br>
                    <span>Rp. {{$harga_detail->harga_detail_jemput}}</span><br>
                    <span class="fl-bigmug-line-big104"></span> <span>Antar ke {{$booking->booking_lokasi_antar}}</span><br>
                    <span>Rp. {{$harga_detail->harga_detail_antar}}</span><br>
                    <span class="fl-bigmug-line-big104"></span> <span>Harga Tiket</span><br>
                    <span>Rp. {{$harga_detail->harga_detail_tiket}} x {{$booking->booking_jmlh_penumpang}} orang</span>
                 </div>
               </div>
              </div>

              <div class="ml-auto">
              <form action="{{ route('pesan') }}" method="post">
                @csrf
                <input type="hidden" name="transaksi_order_id" value="{{$booking->transaksi_order_id}}">
                <input type="submit" class="btn btn-primary py-2" value="Pesan Jeep">
              </form>
              </div>

           </div>
         </div>
        </div>

      </div>
    </div>    

@endsection