@extends('layouts.client')

@section('content')

    <div class="unit-5 bg-secondary">
      <div class="container text-center">
        <h2 class="mb-0">Pusat Bantuan</h2>
        <p class="mb-0 unit-6"><a href="{{route('home')}}">Home</a> <span class="sep">></span> <span>Pusat Bantuan</span></p>
      </div>
    </div>

    <div class="site-section">
      <div class="container">

        <div class="row row-custom align-items-center">
          <div class="col-md-12">
            <div class="job-search">
              <ul class="nav nav-pills mb-3 faq" id="pills-tab" role="tablist">

                <li class="nav-item">
                  <a class="nav-link active py-3" id="pills-job-tab" data-toggle="pill" href="#pills-job" role="tab" aria-controls="pills-job" aria-selected="true">Penumpang</a>
                  
                </li>
                <li class="nav-item">
                  <a class="nav-link py-3" id="pills-candidate-tab" data-toggle="pill" href="#pills-candidate" role="tab" aria-controls="pills-candidate" aria-selected="false">Mitra Pengemudi</a>
                  
                </li>
                
              </ul>
              <hr class="hr-faq">
              <div class="tab-content bg-white p-4 rounded row justify-content-center" id="pills-tabContent">
              
                <div class="tab-pane fade show active col-md-12" id="pills-job" role="tabpanel" aria-labelledby="pills-job-tab">
                  <div class="row">
                    <div class="col-md">
                      <h3>Topik Populer</h3>
                      <div class="col-md-11">
                        <div class="accordion unit-8" id="accordion">
                          <div class="accordion-item">
                            <h3 class="mb-0 heading">
                              <a class="btn-block" data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="true" aria-controls="collapseOne">Bagaimana cara memesan jeep di ngeJIP.com?<span class="icon"></span></a>
                            </h3>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                              <div class="body-text">
                                <p>Pemesanan jeep cukup melalui cara berikut:</p>
                                <ol>
                                  <li>Isi formulir pada bagian <strong>'Waktu dan Lokasi'</strong>.
                                    <!-- <img src="faq/penumpang/pemesanan-waktu-lokasi.jpg" alt="pemesanan-waktu-lokasi" class="faq-image-tabs-pemesanan"> -->
                                    <ol style="a">
                                      <li>Tanggal pemberangkatan</li>
                                      <li>Lokasi penjemputan</li>
                                      <li>Lokasi antar (pulang)</li>
                                    </ol>                                  
                                  </li>
                                  <li>Isi juga formulir pada bagian <strong>'Jenis dan Jumlah'</strong>.
                                    <!-- <img src="faq/penumpang/pemesanan-jenis-jumlah.jpg" alt="pemesanan-jenis-jumlah" class="faq-image-tabs-pemesanan"> -->
                                    <ol type="a">
                                      <li>Jumlah penumpang. 
                                        <p>*Batas pemesanan 6 penumpang, lakukan pemesanan lagi jika lebih dari 6.</p>
                                      </li>
                                      <li>Jenis trip: Sunrise/Panorama.</li>
                                    </ol>
                                  </li>
                                  <li>Lakukan pencarian dengan menekan tombol 'Search'.
                                  </li>
                                  <li>Anda akan diarahkan ke halaman <strong>'Harga Total'</strong>.
                                  </li>
                                  <li>Lakukan pembayaran melalui tombol <strong>'Pesan Jeep'.</strong>
                                    <!-- <img src="faq/penumpang/pemesanan-estimasi-biaya.jpg" alt="pemesanan-estimasi-biaya" class="faq-image-tabs-pemesanan"> -->
                                  </li>
                                  <li>Berikutnya anda akan diarahkan untuk mengisi <strong>'Data Pemesan'</strong>. Tekan <strong>'Lanjutkan Pembayaran'</strong> untuk proses pembayaran.
                                    <!-- <img src="faq/penumpang/pemesanan-input-data-pemesan.jpg" alt="pemesanan-input-data-pemesan" class="faq-image-tabs-pemesanan"> -->
                                  </li>
                                </ol>
                              </div>
                            </div>
                          </div> <!-- .accordion-item -->
                          
                          <div class="accordion-item">
                            <h3 class="mb-0 heading">
                              <a class="btn-block" data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="false" aria-controls="collapseTwo">Bagaimana cara membayar pesanan di ngeJIP.com?<span class="icon"></span></a>
                            </h3>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                              <div class="body-text">
                                <p>Setelah melakukan mengisi formulir pemesanan dan pengisian data pemesan anda akan diarahkan ke halaman pemesanan. Pembayaran dilakukan dengan cara:</p>
                                <ol>
                                  
                                  <li>Pembayaran hanya dilakukan melalui <strong>'Partner Pembayaran'</strong> ngeJIP.com melalui: 
                                    <ol type="a">
                                      <li>Credit Card</li>
                                      <li>ATM/Bank Transfer</li>
                                      <li>Go-PAY</li>
                                      <li>KlikBCA</li>
                                      <li>BCA KlikPay</li>
                                      <li>Mandiri KlikPay</li>
                                      <li>CIMB Clicks</li>
                                      <li>Danamon Online Banking</li>
                                      <li>e-Pay BRI</li>
                                      <li>LINE Pay e-cash | Mandiri e-cash</li>
                                      <li>Telkomsel Cash</li>
                                      <li>XL Tunai, dan </li>
                                      <li>Indomaret</li>
                                    </ol>
                                  </li>
                                  <li>Anda akan mendapatkan Ivoice melalui email yang sudah diinputkan berupa <strong>'Harga Total'</strong> dan <strong>'ID Transaksi'</strong></li>
                                  <li>Durasi pembayaran <strong>2 Jam</strong> setelah anda memilih <strong>'Partner Pembayaran'</strong>.</li>
                                  <li>Setelah melakukan pembayan anda akan menerima konfirmasi melalui <strong>'Email'</strong> dan akan disertakan <strong>Identitas Driver</strong> dan <strong>Route perjalanan ngeJIP</strong> anda.</li>
                                </ol>
                              </div>
                            </div>
                          </div> <!-- .accordion-item -->

                          <div class="accordion-item">
                            <h3 class="mb-0 heading">
                              <a class="btn-block" data-toggle="collapse" href="#collapseThree" role="button" aria-expanded="false" aria-controls="collapseThree">Bagaimana cara melihat pemesanan?  <span class="icon"></span></a>
                            </h3>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                              <div class="body-text">
                                <p>Untuk melihat pemesanan yang anda lakukan, silakan kunjungi halaman <a href="#">Cek Pemesanan</a>:</p>
                                <ol>
                                  <li>Mengisi <strong>ID Pemesanan</strong> dan <strong>Email pemesanan</strong>.</li>
                                  <li>Lakukan pencarian dengan menekan tombol <strong>'Cek Pemesanan'</strong></li>
                                  <li>Jika ditemukan, <strong>data pemesanan</strong> anda akan muncul.</li>
                                </ol>
                              </div>
                            </div>
                          </div> <!-- .accordion-item -->

                          <div class="accordion-item">
                            <h3 class="mb-0 heading">
                              <a class="btn-block" data-toggle="collapse" href="#collapseFour" role="button" aria-expanded="false" aria-controls="collapseFour">Bagaimana cara membatakan pemesanan?<span class="icon"></span></a>
                            </h3>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                              <div class="body-text">
                                <p>Pemesanan <strong>otomatis dibatalkan</strong> jika anda tidak melakukan pembayaran <strong>Maksimal 2 Jam</strong> setelah melakukan transaksi pemesanan.</p>
                              </div>
                            </div>
                          </div> <!-- .accordion-item -->

                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 faq-image-tabs row justify-content-center">
                      <img src="{{ url('images/contact-us-icon.png') }}"class="faq-image">
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="pills-candidate" role="tabpanel" aria-labelledby="pills-candidate-tab">
                  <p>Mitra pengemudi</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection