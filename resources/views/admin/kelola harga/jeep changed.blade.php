@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Harga Jeep Changed<small></small></h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Harga Jeep Changed</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-9">
          {{-- Harga Jeep Changed --}}
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Daftar Harga Jeep Changed</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Nominal</th>
                  <th>Jenis</th>
                  <th>Paket</th>
                  <th>Mulai tanggal</th>
                  <th>Sampai tanggal</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>                 
                  @foreach($hargaJeepChangeds as $hargaJeepChanged)
                  <tr id="jeep-changed-{{$hargaJeepChanged->idharga_jeep_changed}}">
                    <td>{{$hargaJeepChanged->harga_jeep_changed_nominal}}</td>
                    <td>{{$hargaJeepChanged->harga_jeep_changed_jenis}}</td>
                    <td>{{$hargaJeepChanged->harga_jeep_changed_paket}}</td>
                    <td>{{$hargaJeepChanged->harga_jeep_changed_tgl_start}}</td>
                    <td>{{$hargaJeepChanged->harga_jeep_changed_tgl_finish}}</td>
                    <td>
                      <button type="button" class="btn btn-danger btn-sm delete-jeep-changed" 
                      data-id="{{$hargaJeepChanged->idharga_jeep_changed}}"><i class="fa fa-fw fa-trash"></i> Hapus</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Nominal</th>
                  <th>Jenis</th>
                  <th>Paket</th>
                  <th>Mulai tanggal</th>
                  <th>Sampai tanggal</th>
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
          {{-- Tambah Harga Jeep Changed --}}
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Harga Jeep Changed</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->         
            <form action="{{ route('jeep-changed.store') }}" method="post">
                {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="harga_jeep_changed_nominal">Nominal Harga</label>
                  <input type="number" class="form-control" name="harga_jeep_changed_nominal" placeholder="Masukkan nominal harga">
                </div>
                <div class="form-group">
                  <label for="harga_jeep_changed_tgl_start">Mulai Tanggal</label>
                  <input type="date" class="form-control" name="harga_jeep_changed_tgl_start" placeholder="Masukkan tanggal">
                </div>
                <div class="form-group">
                  <label for="harga_jeep_changed_tgl_finish">Sampai Tanggal</label>
                  <input type="date" class="form-control" name="harga_jeep_changed_tgl_finish" placeholder="Masukkan tanggal">
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

    $(document).on('click', '.delete-jeep-changed', function() {
      var id = $(this).data("id");
      var status = confirm("Are sure to delete it?");
      if(status){
        $.ajax({
          type: 'DELETE',
          url: '/admin/harga/jeep-changed/'+id,
          headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            $('#jeep-changed-'+data.idharga_jeep_changed).remove();
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