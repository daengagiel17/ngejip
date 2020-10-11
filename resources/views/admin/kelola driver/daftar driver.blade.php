@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Driver <small>{{$drivers->count()}} orang</small></h1>
      <ol class="breadcrumb">
          <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Data Driver</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-9">
          {{-- Harga Jeep Changed --}}
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Daftar Driver</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Username</th>
                  <th>Nama</th>
                  <th>No Handphone</th>
                  <th>Jumlah Orderan</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($drivers as $driver)
                  <tr id="driver-{{$driver->iddriver}}">
                    <td>{{$driver->driver_username}}</td>
                    <td>{{$driver->driver_nama}}</td>
                    <td>{{$driver->driver_nohp}}</td>
                    <td>{{$driver->driver_jmlh_orderan}}</td>
                    <td>
                      {{-- <form action="{{route('delete-driver', ['id' => $driver->iddriver])}}" method="POST">
                          @method('DELETE') @csrf
                          <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Hapus</button>
                      </form> --}}
                      <a class="btn btn-primary btn-sm" href="{{route('driver.show', ['id' => $driver->iddriver])}}"><i class="fa fa-fw fa-eye"></i> Detail</a>
                      <label class="btn btn-danger btn-sm delete" data-id="{{$driver->iddriver}}"><i class="fa fa-fw fa-trash"></i> Hapus</label>
                    </td>
                  </tr>
                  @endforeach
                  </form>
                </tbody>
                <tfoot>
                <tr>
                  <th>Username</th>
                  <th>Nama</th>
                  <th>No Handphone</th>
                  <th>Jumlah Orderan</th>
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
          {{-- Driver --}}
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Driver</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ route('driver.store') }}" method="post">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="username_driver">Username</label>
                  <input type="text" class="form-control" name="username_driver" placeholder="Masukkan username">
                </div>
                <div class="form-group">
                  <label for="nama_driver">Nama Driver</label>
                  <input type="text" class="form-control" name="nama_driver" placeholder="Masukkan nama driver">
                </div>
                <div class="form-group">
                  <label for="no_hp_driver">Nomor Handphone<br>(Gunakan kode negara 62)</label>
                  <input type="tel" class="form-control" name="nohp_driver" placeholder="628123456789">
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
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