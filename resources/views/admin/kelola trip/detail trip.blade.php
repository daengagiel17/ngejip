@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Detail Trip<small>( ID Order {{$data->order_id}} )</small></h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('trip.index')}}">Data Trip</a></li>
        <li class="active">Detail Trip</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-4">
          <!-- Profile Driver -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center">Data Pemesan</h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Nama Pemesan</b> <a class="pull-right">{{$data->booking_nama}}</a>
                </li>
                <li class="list-group-item">
                  <b>Nomor Handphone</b> <a class="pull-right">{{$data->booking_nohp}}</a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right">{{$data->booking_email}}</a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- Profile Driver -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center">Data Driver</h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Username Driver</b> <a class="pull-right">{{$data->driver_username}}</a>
                </li>
                <li class="list-group-item">
                  <b>Nama Driver</b> <a class="pull-right">{{$data->driver_nama}}</a>
                </li>
                <li class="list-group-item">
                  <b>No HP Driver</b> <a class="pull-right">{{$data->driver_nohp}}</a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-xs-4">
          <!-- Profile Driver -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center">Data Pemesanan</h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Tanggal Berangkat</b> <a class="pull-right">{{$data->booking_tgl_berangkat}}</a>
                </li>
                <li class="list-group-item">
                  <b>Jumlah</b> <a class="pull-right">{{$data->booking_jmlh_penumpang}} orang</a>
                </li>
                <li class="list-group-item">
                  <b>Lokasi Antar</b> <a class="pull-right">{{$data->harga_antar_lokasi}}</a>
                </li>
                <li class="list-group-item">
                  <b>Lokasi Jemput</b> <a class="pull-right">{{$data->harga_jemput_lokasi}}</a>
                </li>
                <li class="list-group-item">
                  <b>Status</b> <a class="pull-right">{{$data->booking_status}}</a>
                </li>
                <li class="list-group-item">
                  <b>Waktu Pemesanan</b> <a class="pull-right">{{$data->updated_at}}</a>
                </li>
                <li class="list-group-item">
                  <b>Waktu Pelunasan</b> <a class="pull-right">{{$data->transaction_time}}</a>
                </li>
                <li class="list-group-item">
                  <b>Tipe Pembayaran</b> <a class="pull-right">{{$data->payment_type}}</a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-xs-4">
          <!-- Profile Driver -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center">Data Biaya</h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Biaya Jeep</b> <a class="pull-right">Rp. {{$data->harga_detail_jeep}}</a>
                </li>
                <li class="list-group-item">
                  <b>Biaya Tiket</b> <a class="pull-right">{{$data->booking_jmlh_penumpang}} x Rp. {{$data->harga_detail_tiket}}</a>
                </li>
                <li class="list-group-item">
                  <b>Biaya Antar</b> <a class="pull-right">Rp. {{$data->harga_detail_antar}}</a>
                </li>
                <li class="list-group-item">
                  <b>Biaya Jemput</b> <a class="pull-right">Rp. {{$data->harga_detail_jemput}}</a>
                </li>
                <li class="list-group-item">
                  <b>Total Biaya</b> <a class="pull-right">Rp. {{$data->total_harga}}</a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection

@section('js-script')
  <!-- jQuery 3 -->
  <script src="{{url('bower_components/jquery/dist/jquery.min.js')}}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{url('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  <!-- DataTables -->
  <script src="{{url('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{url('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
  <!-- SlimScroll -->
  <script src="{{url('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{url('bower_components/fastclick/lib/fastclick.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{url('dist/js/adminlte.min.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{url('dist/js/demo.js')}}"></script>
  <!-- page script -->
@endsection