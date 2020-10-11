@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Booking<small>( {{$booking->count()}} booking )</small></h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Booking</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$jmlh_cek}}</h3>

              <p>Booking Cek</p>
            </div>
            <div class="icon">
              <i class="fa fa-tasks"></i>
            </div>
            <a href="{{ route('booking.cek') }}" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$jmlh_pesan}}</h3>

              <p>Booking Pesan</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            <a href="{{ route('booking.pesan') }}" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$jmlh_pembayaran}}</h3>

              <p>Booking Pembayaran</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="{{ route('booking.pembayaran') }}" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- /.col -->

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>{{$jmlh_lunas}}</h3>

              <p>Booking Lunas</p>
            </div>
            <div class="icon">
              <i class="fa fa-check-circle"></i>
            </div>
            <a href="{{ route('booking.lunas') }}" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-xs-12">
          {{-- Harga Jeep Changed --}}
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Daftar Booking</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Tanggal Berangkat</th>
                  <th>Order ID</th>
                  <th>Jumlah Penumpang</th>
                  <th>Total Biaya</th>
                  <th>Status Pembayaran</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($booking as $booking)
                  <tr>
                    <td>{{\Carbon\Carbon::parse($booking->booking_tgl_berangkat)->format('d/m/Y')}}</td>
                    <td>{{$booking->transaksi_order_id}}</td>
                    <td>{{$booking->booking_jmlh_penumpang}} orang</td>
                    <td>{{$booking->total_harga}}</td>
                    <td>{{$booking->booking_status_pembayaran}}</td>
                  </tr>
                  @endforeach
                  </form>
                </tbody>
                <tfoot>
                <tr>
                  <th>Tanggal Berangkat</th>
                  <th>Order ID</th>
                  <th>Jumlah Penumpang</th>
                  <th>Total Biaya</th>
                  <th>Status Pembayaran</th>
                </tr>
                </tfoot>
              </table>
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
  <script>
    $(function () {
      $('#example1').DataTable()
    })

  </script>
@endsection