@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Harga Tiket</h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Harga Tiket</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="col-xs-9">
            {{-- Daftar Harga Tiket --}}
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Daftar Harga Tiket</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Harga Weekend</th>
                    <th>Harga Weekday</th>
                    <th>Berlaku per tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($hargaTikets as $hargaTiket)
                    <tr id="harga-tiket-{{$hargaTiket->idharga_tiket}}">
                      <td>{{$hargaTiket->harga_tiket_weekend}}</td>
                      <td>{{$hargaTiket->harga_tiket_weekday}}</td>
                      <td>{{$hargaTiket->harga_tiket_pertanggal}}</td>
                      <td>{{$hargaTiket->harga_tiket_status}}</td>
                      <td>
                        <button type="button" class="btn btn-danger btn-sm delete-harga-tiket"
                        data-id="{{$hargaTiket->idharga_tiket}}"><i class="fa fa-fw fa-trash"></i> Hapus</button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Harga Weekend</th>
                    <th>Harga Weekday</th>
                    <th>Berlaku per tanggal</th>
                    <th>Status</th>
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
            {{-- Tambah Harga Tiket --}}
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Tambah Harga Tiket</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form action="{{ route('tiket.store') }}" method="post">
                  {{ csrf_field() }}
                <div class="box-body">
                  <div class="form-group">
                    <label for="harga_tiket_weekend">Nominal Harga Weekend</label>
                    <input type="number" class="form-control" name="harga_tiket_weekend" placeholder="Masukkan nominal harga">
                  </div>
                  <div class="form-group">
                    <label for="harga_tiket_weekday">Nominal Harga Weekday</label>
                    <input type="number" class="form-control" name="harga_tiket_weekday" placeholder="Masukkan nominal harga">
                  </div>
                  <div class="form-group">
                    <label for="harga_tiket_pertanggal">Berlaku Per Tanggal</label>
                    <input type="date" class="form-control" name="harga_tiket_pertanggal" placeholder="Masukkan tanggal">
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

    $(document).on('click', '.delete-harga-tiket', function() {
      var id = $(this).data("id");
      var status = confirm("Are sure to delete it?");
      if(status){
        $.ajax({
          type: 'DELETE',
          url: '/admin/harga/tiket/'+id,
          headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            $('#harga-tiket-'+data.idharga_tiket).remove();
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