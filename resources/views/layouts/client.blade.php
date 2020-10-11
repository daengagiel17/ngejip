<!DOCTYPE html>
<html lang="en">
  <head>
    <title>NgeJIP | Ngetrip makin sip</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fav Icon -->
    <link rel="shortcut icon" href="{{url('images/icon.jpeg')}}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500"> 
    <link rel="stylesheet" href="{{url('fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{url('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{url('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{url('css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{url('css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{url('css/animate.css')}}">
    
    
    <link rel="stylesheet" href="{{url('fonts/flaticon/font/flaticon.css')}}">
    <link rel="stylesheet" href="{{url('css/fl-bigmug-line.css')}}">
  
    <link rel="stylesheet" href="{{url('css/aos.css')}}">

    <link rel="stylesheet" href="{{url('css/style.css')}}">
    
  </head>
  <body>
  
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
    
    
    <header class="site-navbar py-1" role="banner">

      <div class="container">
        <div class="row align-items-center">
          
          <div class="col-6 col-xl-2">
            <h1 class="mb-0"><a href="{{route('home')}}" class="text-black h2 mb-0">Nge<strong>JIP</strong></a></h1>
          </div>

          <div class="col-10 col-xl-10 d-none d-xl-block">
            <nav class="site-navigation text-right" role="navigation">

              <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                <li class="active"><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('list-pesanan')}}">Cek Pesanan</a></li>
                <li><a href="{{route('faq')}}">Pusat Bantuan</a></li>
                <li>
                  @auth
                    <form action="{{ route('logout-otp') }}" method="POST">
                      @csrf
                      <button type="submit" class="btn btn-default btn-flat btn-block">Sign Out</button>
                    </form>
                  @endauth
                  @guest
                    <a href="{{route('login-otp', ['state' => "home"])}}">Sign In</a>
                    {{-- <a href="{{route('login')}}">Sign In</a> --}}
                  @endguest
                </li>
              </ul>
            </nav>
          </div>

          <div class="col-6 col-xl-2 text-right d-block">
            
            <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

          </div>

        </div>
      </div>
      
    </header>
      @yield('content')     

      <footer class="site-footer" style="background: #222831;">
        <div class="container">
  
          <div class="row mb-5">
            <div class="col-md-4">
              <div class="ftco-footer-widget mb-3">
                <img src="{{url('images/foot-ngejip.png')}}" alt="ngejip.com" style="width: 230px;">
              </div>
              <div class=" col row d-flex mb-4" style="align-items: center;">
                  <div class="col-md-2">
                    <span class="icon-clock-o" style="font-size: 35px;"></span>
                  </div>
                  <div class="col-md-10">
                    <p class="mb-0">Call now</p>
                    <h5>0858 1991 0714</h5>
                  </div>
              </div>
              <div class="ftco-footer-widget mb-3">
                <h2 class="ftco-heading-2" style="color: #fff;">Partner pembayaran</h2>
                <div class="container">
                  <div class="row">
                    <div class="mb-1 my-1">
                    <img src="{{url('images/metode-pembayaran/credit-card.png')}}" alt="credit-card" class="mb-1 rounded" style="background: #2d333b;">
                      <img src="{{url('images/metode-pembayaran/atm-bank-transfer.png')}}" alt="atm-bank-transfer" class="mb-1 rounded" style="background: #2d333b;">
                      <img src="{{url('images/metode-pembayaran/go-pay.png')}}" alt="go-pay" class="mb-1 rounded" style="background: #2d333b;">
                      <img src="{{url('images/metode-pembayaran/klik-bca.png')}}" alt="klik-bca" class="mb-1 rounded" style="background: #2d333b;">
                      <img src="{{url('images/metode-pembayaran/mandiri-clickpay.png')}}" alt="mandiri-clickpay" class="mb-1 rounded" style="background: #2d333b;">
                      <img src="{{url('images/metode-pembayaran/cimb-clicks.png')}}" alt="cimb-clicks" class="mb-1 rounded" style="background: #2d333b;">
                      <img src="{{url('images/metode-pembayaran/danamon-online-banking.png')}}" alt="danamon-online-banking" class="mb-1 rounded" style="background: #2d333b;">
                      <img src="{{url('images/metode-pembayaran/e-pay-bri.png')}}" alt="e-pay-bri" class="mb-1 rounded" style="background: #2d333b;">
                      <img src="{{url('images/metode-pembayaran/line-pay-e-cash.png')}}" alt="line-pay-e-cash" class="mb-1 rounded" style="background: #2d333b;">
                      <img src="{{url('images/metode-pembayaran/telkomsel-cash.png')}}" alt="telkomsel-cash" class="mb-1 rounded" style="background: #2d333b;">
                      <img src="{{url('images/metode-pembayaran/xl-tunai.png')}}" alt="xl-tunai" class="mb-1 rounded" style="background: #2d333b;">
                      <img src="{{url('images/metode-pembayaran/indomaret.png')}}" alt="indomaret" class="mb-1 rounded" style="background: #2d333b;">
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="ftco-footer-widget mb-4">
                <h2 class="ftco-heading-2" style="color: #fff;">Tentang</h2>
                <ul class="list-unstyled">
                  <li><a href="{{route('faq')}}">Cara pemesanan</a></li>
                    <li><a href="{{route('contact')}}">Hubungi kami</a></li>
                    <li><a href="{{route('faq')}}">Pusat bantuan</a></li>
                    <li><a href="{{route('about')}}">Tentang kami</a></li>
                    <li><a href="{{route('karir')}}">Karir</a></li>
                </ul>
              </div>
            </div>
            <div class="col-md-2">
              <div class="ftco-footer-widget mb-4 ml-md-4">
                <h2 class="ftco-heading-2" style="color: #fff;">Layanan</h2>
                <ul class="list-unstyled">
                  <li><a href="{{route('term')}}">Ketentuan layanan</a></li>
                  <li><a href="{{route('privacy')}}">Kebijakan privasi</a></li>
                </ul>
              </div>
            </div>
            <div class="col-md-4">
              <div class="ftco-footer-widget mb-4 ml-md-">
                <h2 class="ftco-heading-2" style="color: #fff;">Punya pertanyaan?</h2>
                <div class="block-23 mb-3">
                  <ul class="list-unstyled">
                    <li class="mb-3"><a href="mailto:support@irit-io.id">support@itir-io.id</a> </li>
                    <li>
                      <h4 style="color: white;">Follow us</h4>
                      
                      <a href="https://instagram.com/ngejipmalang" class="btn rounded-circle text-gray-500" target="_blank" style="background-color: #2d333b;"><span class="icon-instagram"></span></a>
                      <a href="https://www.facebook.com/ngejip.malang" target="_blank" class="btn rounded-circle text-gray-500"style="background-color: #2d333b;"><span class="icon-facebook"></span></a>
                      <a href="https://twitter.com/ngejip" target="_blank" class="btn rounded-circle text-gray-500"style="background-color: #2d333b;"><span class="icon-twitter"></span></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
  
          <div class="row mt-5 text-center">
            <div class="col-md-12">
              <a href="https://api.whatsapp.com/send?phone=6282146503912">Hubungi kami</a>
              <p>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy; <script>document.write(new Date().getFullYear());</script> Irit.io All Rights Reserved.
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              </p>
            </div>
            
          </div>
        </div>
      </footer>

    {{-- <footer>
      <div class="container">
        <div class="row mt-3 text-center">
          <div class="col-md-12">
            <p>Copyright &copy; All Rights Reserved | This template is made with <i class="icon-heart text-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
          </div>          
        </div>
      </div>
    </footer> --}}
  </div>

  <script src="{{url('js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{url('js/jquery-migrate-3.0.1.min.js')}}"></script>
  <script src="{{url('js/jquery-ui.js')}}"></script>
  <script src="{{url('js/popper.min.js')}}"></script>
  <script src="{{url('js/bootstrap.min.js')}}"></script>
  <script src="{{url('js/owl.carousel.min.js')}}"></script>
  <script src="{{url('js/jquery.validate.min.js')}}"></script>
  <script src="{{url('js/jquery.stellar.min.js')}}"></script>
  <script src="{{url('js/jquery.countdown.min.js')}}"></script>
  <script src="{{url('js/jquery.magnific-popup.min.js')}}"></script>
  <script src="{{url('js/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{url('js/aos.js')}}"></script>  
  <script src="{{url('js/main.js')}}"></script>
    @yield('script')
  </body>
</html>