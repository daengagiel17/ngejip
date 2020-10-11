@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Detail Driver <small>( daftar order, profil driver )</small></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('driver.index')}}">Data Driver</a></li>
        <li class="active">Detail Driver</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-9">
          {{-- Harga Jeep Changed --}}
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Daftar Orderan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Order Id</th>
                  <th>Status Antrian</th>
                  <th>Status Booking</th>
                  <th>Tanggal Berangkat</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($antrians as $antrian)
                  <tr>
                    <td>{{$antrian->booking->transaksi_order_id}}</td>
                    <td>{{$antrian->antriandriver_status}}</td>
                    <td>{{$antrian->booking->booking_status}}</td>
                    <td>{{$antrian->booking->booking_tgl_berangkat}}</td>
                    <td>
                      <label class="btn btn-primary btn-sm"><i class="fa fa-fw fa-eye"></i> Detail Order</label>
                    </td>
                  </tr>
                  @endforeach
                  </form>
                </tbody>
                <tfoot>
                <tr>
                  <th>Order Id</th>
                  <th>Status Antrian</th>
                  <th>Status Booking</th>
                  <th>Tanggal Berangkat</th>
                  <th>Aksi</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-xs-3">

          <!-- Profile Driver -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{url('dist/img/user4-128x128.jpg')}}" alt="User profile picture">

              <h3 class="profile-username text-center">{{$driver->driver_username}}</h3>

              <p class="text-muted text-center">{{$driver->driver_nama}}</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Jumlah Orderan</b> <a class="pull-right">{{$antrians->count()}}</a>
                </li>
                <li class="list-group-item">
                  <b>Jumlah Decline</b> <a class="pull-right">{{$antrians->where('antriandriver_status','decline')->count()}}</a>
                </li>
                <li class="list-group-item">
                  <b>Tingkat</b> 
                  <a class="pull-right">
                    <i class="fa fa-star"></i> 
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i> 
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i> 
                  </a>
                </li>
              </ul>

              <label class="btn btn-success btn-block">
                <b> Driver Baik</b>
              </label>
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

    $(document).on('click', '.delete', function() {
      var id = $(this).data("id");
      var status = confirm("Are sure to delete it?");
      if(status){
        $.ajax({
          type: 'DELETE',
          url: '/admin/driver/'+id,
          headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            $('#driver-'+data.iddriver).remove();
            console.log("Sukses", data);
          },
          error: function(data){
            console.log(data);
          }
        });
      }
    });  

  </script>
@endsection