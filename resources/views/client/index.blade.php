@extends('layouts.client')

@section('content')

    <div class="site-blocks-cover" style="background-image: url(images/bg-index.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row row-custom align-items-center">
          <div class="col-md-10">
            @if (\Session::has('danger'))
              <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <strong>Mohon maaf !</strong> {!! \Session::get('danger') !!}
              </div>
            @endif
            <h1 class="mb-2 text-black w-75"><span class="font-weight-bold">Ngetrip</span><br>makin sip</h1>
            <div class="job-search">
              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active py-3" id="pills-job-tab" data-toggle="pill" href="#pills-job" role="tab" aria-controls="pills-job" aria-selected="true">Private Trip</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link py-3" id="pills-candidate-tab" data-toggle="pill" href="#pills-candidate" role="tab" aria-controls="pills-candidate" aria-selected="false">Open Trip</a>
                </li>
              </ul>
              <div class="tab-content bg-white p-4 rounded" id="pills-tabContent">
                  {{-- Private Trip --}}
                  <div class="tab-pane fade show active" id="pills-job" role="tabpanel" aria-labelledby="pills-job-tab">
                    <form action="{{ route('cek-harga-private') }}" method="post">
                      {{ csrf_field() }}      
                    <div class="row">
                      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <input type="date" name="tgl_booking" class="form-control" min="{{$tomorrow}}" value="{{ old('tgl_booking') }}">
                        @if ($errors->has('tgl_booking'))
                          <span class="text-danger">{{ $errors->first('tgl_booking') }}</span>
                        @endif                        
                      </div>
                      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <div class="select-wrap">
                          <span class="icon-keyboard_arrow_down arrow-down"></span>
                          <select name="lokasi_jemput" class="form-control">
                            <option value="">Lokasi Jemput</option>
                            <option value="tumpang">Tumpang</option>
                            <option value="malang">Malang</option>
                            <option value="batu">Batu</option>
                          </select>
                          @if ($errors->has('lokasi_jemput'))
                            <span class="text-danger">{{ $errors->first('lokasi_jemput') }}</span>
                          @endif 
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <div class="select-wrap">                   
                          <span class="icon-keyboard_arrow_down arrow-down errors"></span>
                          <select name="lokasi_antar" class="form-control">
                            <option value="">Lokasi Antar</option>
                            <option value="tumpang">Tumpang</option>
                            <option value="malang">Malang</option>
                            <option value="batu">Batu</option>
                          </select>
                          @if ($errors->has('lokasi_antar'))
                            <span class="text-danger">{{ $errors->first('lokasi_antar') }}</span>
                          @endif 
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <div class="select-wrap">
                          <span class="icon-keyboard_arrow_down arrow-down"></span>
                          <select name="jmlh_penumpang" class="form-control">
                            <option value="">Jumlah Penumpang</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                          </select>
                          @if ($errors->has('jmlh_penumpang'))
                            <span class="text-danger">{{ $errors->first('jmlh_penumpang') }}</span>
                          @endif 
                        </div>                        
                      </div>
                      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <div class="select-wrap">
                          <span class="icon-keyboard_arrow_down arrow-down"></span>
                          <select name="paket_trip" class="form-control">
                            <option value="">Paket Trip</option>
                            <option value="sunrise">Sunrise</option>
                            <option value="panorama">Panorama</option>
                          </select>

                          {{-- <select name="paket_trip" class="form-control">
                            @foreach ($collection as $item)
                              <option value="{{$item}}">{{$item}}</option>
                            @endforeach
                          </select> --}}
                          @if ($errors->has('paket_trip'))
                            <span class="text-danger">{{ $errors->first('paket_trip') }}</span>
                          @endif 
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <input type="submit" class="btn btn-primary btn-block" value="Search">
                      </div>
                    </div>
                    </form>
                  </div>
                  {{-- Open Trip --}}
                  <div class="tab-pane fade" id="pills-candidate" role="tabpanel" aria-labelledby="pills-candidate-tab">
                    <form action="{{ route('cek-harga-open') }}" method="post">
                      {{ csrf_field() }}  
                    <div class="row">
                      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <input type="date" name="tgl_booking" class="form-control" min="{{$tomorrow}}" value="{{ old('tgl_booking') }}">
                        @if ($errors->has('tgl_booking'))
                          <span class="text-danger">{{ $errors->first('tgl_booking') }}</span>
                        @endif                        
                      </div>
                      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <div class="select-wrap">
                          <span class="icon-keyboard_arrow_down arrow-down"></span>
                          <select name="jmlh_penumpang" class="form-control">
                            <option value="">Jumlah Penumpang</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                          </select>
                          @if ($errors->has('jmlh_penumpang'))
                            <span class="text-danger">{{ $errors->first('jmlh_penumpang') }}</span>
                          @endif 
                        </div>                        
                      </div>
                      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <input type="submit" class="btn btn-primary btn-block" value="Search">
                      </div>
                    </div>
                    </form>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>  
    <!-- pemesanan -->

    <div class="site-section penggunaan">
      <div class="container py-4">
        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-6" data-aos="fade" >
            <h2>Cara mudah ngetrip bareng<strong> ngeJIP</strong> </h2>
            <h5>Nikmati kemudahan ngetrip!</h5>
          </div>
        </div>
        <div class="row">
          <div class="col-md-1"></div>

          <div class="container col-md-6 nav nav-pills" data-aos="fade" data-aos-delay="100">
            <a href="" data-target="#prototype-ngejip" data-slide-to="0">
              <div class="d-flex">
                <div class="pr-4" style="padding-right: 1.5rem!important;">
                  <div class="rounded-circle penggunaan-num" style="background: #0953a6;">
                    <h3>1</h3>
                  </div>
                </div>
                <div class="icon text">
                  <h5>Pemesanan</h5>
                  <p>Masuk halaman utama pada aplikasi atau website ngeJIP untuk melakukan pemesanan.</p>
                </div>
              </div>
            </a>
            <a href="" data-target="#prototype-ngejip" data-slide-to="1">
              <div class="d-flex">
                <div class="pr-4" style="padding-right: 1.5rem!important;">
                  <div class="rounded-circle penggunaan-num" style="background: #0953a6;">
                    <h3>2</h3>
                  </div>
                </div>
                <div class="icon text">
                  <h5>Pengisian data</h5>
                  <p>Isi form secara lengkap dan anda akan diarahkan ke halaman <strong>Rincian</strong> dan <strong>Pembayaran</strong>.</p>
                </div>
              </div>
            </a>
            <a href="" data-target="#prototype-ngejip" data-slide-to="2">
              <div class="d-flex">
                <div class="pr-4" style="padding-right: 1.5rem!important;">
                  <div class="rounded-circle penggunaan-num" style="background: #0953a6;">
                    <h3>3</h3>
                  </div>
                </div>
                <div class="icon text">
                  <h5>Pembayaran</h5>
                  <p>Bayar melalui parter Pembayaran ngeJIP, terdapat <strong>12 metode</strong> pembayaran. Pilih salah satu.</p>
                </div>
              </div>
            </a>
            <a href="" data-target="#prototype-ngejip" data-slide-to="3">
              <div class="d-flex">
                <div class="pr-4" style="padding-right: 1.5rem!important;">
                  <div class="rounded-circle penggunaan-num" style="background: #0953a6;">
                    <h3>4</h3>
                  </div>
                </div>
                <div class="icon text">
                  <h5>Konfirmasi</h5>
                  <p>Kami akan mengirimkan <strong>konfirmasi Transaksi melalui Email</strong> anda dengan rincian Transaksi dan Detail Jadwal keberangkatan beserta Driver.</p>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-5 py-3 justify-content-center text-center" style="position: inherit;" >
            <div class="nonloop-block-4 owl-carousel" data-aos="fade">
              <div id="prototype-ngejip" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img class="penggunaan" src="{{ url('images/prototype/img-1.png') }}" alt="Pemesanan" style="width:300px;">
                  </div>
                  <div class="carousel-item">
                    <img class="penggunaan" src="{{ url('images/prototype/img-3.png') }}" alt="Pengisian data" style="width:300px;">
                  </div>
                  <div class="carousel-item">
                    <img class="penggunaan" src="{{ url('images/prototype/img-4.png') }}" alt="pembayaran" style="width:300px;">
                  </div>
                  <div class="carousel-item">
                    <img class="penggunaan" src="{{ url('images/prototype/img-6.png') }}" alt="Konfirmasi" style="width:300px;">
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <hr>
      </div>
      <div class="container py-4">
        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-6" data-aos="fade" >
            <h2>Hallo <strong>ngeJIPVania</strong>! </h2>
            <h5>Dengan bromo. Jelajahi lebih dekat!</h5>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">

            <!-- Card -->
            <div class="card card-image mb-3" style="background-image: url('https://pay.google.com/about/static/images/hero/skydiving_t.jpg');">

                <!-- Content -->
                <div class="text-center justify-content-center d-flex align-items-center rgba-black-strong py-5 px-4">
                  <div>
                    <h5><span class="icon-map-pin"></span> Marketing</h5>
                    <h3 class="card-title pt-2 text-black">
                      <strong>This is card title</strong>
                    </h3>
                    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat fugiat, laboriosam, voluptatem.</p> -->
                    <hr>
                    <a class="btn btn-primary text-white waves-effect waves-light">Lihat lebih banyak</a>
                  </div>
                </div>
                <!-- Content -->
            </div>
            <!-- Card -->
            <!-- Card -->
          </div>
          <div class="col-md-6">
            <div class="card card-image mb-3" style="background-image: url('https://pay.google.com/about/static/images/hero/man-car-head-out-window-t.jpg');">

                <!-- Content -->
                <div class="text-center justify-content-center d-flex align-items-center rgba-black-strong py-5 px-4">
                  <div>
                    <h5><span class="icon-av_timer"></span> Marketing</h5>
                    <h3 class="card-title pt-2 text-black">
                      <strong>This is card title</strong>
                    </h3>
                    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat fugiat, laboriosam, voluptatem.</p> -->
                    <hr>

                    <a class="btn btn-primary text-white waves-effect waves-light">Lihat lebih banyak</a>
                  </div>
                </div>
                <!-- Content -->
            </div>
            <!-- Card -->

          </div>
        </div>
      </div>
    </div>
    <!-- penggunaan -->
     
@endsection

@section('script')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
  <script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
  <script>
    webshims.setOptions('waitReady', false);
    webshims.setOptions('forms-ext', {type: 'date'});
    webshims.setOptions('forms-ext', {type: 'time'});
    webshims.polyfill('forms forms-ext');
  </script>
@endsection