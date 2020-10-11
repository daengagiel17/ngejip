@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Driver Off<small></small></h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('driver.index')}}">Data Driver</a></li>
        <li class="active">Data Driver Off</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          {{-- Harga Jeep Changed --}}
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Daftar Driver Off</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Username</th>
                  <th>Nama</th>
                  <th>No Handphone</th>
                  <th>Tanggal Off</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($driversOff as $driverOff)
                  <tr>
                    <td>{{$driverOff->driver->driver_username}}</td>
                    <td>{{$driverOff->driver->driver_nama}}</td>
                    <td>{{$driverOff->driver->driver_nohp}}</td>
                    <td>{{$driverOff->driver_off_tgl}}</td>
                  </tr>
                  @endforeach
                  </form>
                </tbody>
                <tfoot>
                <tr>
                  <th>Username</th>
                  <th>Nama</th>
                  <th>No Handphone</th>
                  <th>Tanggal Off</th>
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