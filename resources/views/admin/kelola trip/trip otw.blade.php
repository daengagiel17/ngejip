@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Trip Otw<small>( {{$jumlah}} trip )</small></h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('trip.index')}}">Data Trip</a></li>
        <li class="active">Data Trip Otw</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      {{-- Daftar Trip --}}
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Trip Otw</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Tanggal Berangkat</th>
                  <th>Order ID</th>
                  <th>Nama Pemesan</th>
                  <th>No HP Pemesan</th>
                  <th>Nama Driver</th>
                  <th>HP Driver</th>
                  <th>Detail</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($trips as $trip)
                  <tr>
                    <td>{{\Carbon\Carbon::parse($trip->booking_tgl_berangkat)->format('d/m/Y')}}</td>
                    <td>{{$trip->transaksi_order_id}}</td>
                    <td>{{$trip->booking_nama}}</td>
                    <td>{{$trip->booking_nohp}}</td>
                    <td>{{$trip->driver_nama}}</td>
                    <td>{{$trip->driver_nohp}}</td>
                    <td>
                      <a class="btn btn-primary btn-sm" href="{{route('trip.show', ['order_id' => $trip->transaksi_order_id])}}"><i class="fa fa-fw fa-eye"></i> Detail</a>
                    </td>
                  </tr>
                  @endforeach
                  </form>
                </tbody>
                <tfoot>
                <tr>
                  <th>Tanggal Berangkat</th>
                  <th>Order ID</th>
                  <th>Nama Pemesan</th>
                  <th>No HP Pemesan</th>
                  <th>Nama Driver</th>
                  <th>No HP Driver</th>
                  <th>Detail</th>
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