@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Harga Antar</h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Harga Antar</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-9">
          {{-- Daftar Harga Antar --}}
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Daftar Harga Antar</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Lokasi</th>
                  <th>Nominal</th>
                  <th>Berlaku per tanggal</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($hargaAntars as $hargaAntar)
                  <tr id="harga-antar-{{$hargaAntar->idharga_antar}}">
                    <td>{{$hargaAntar->harga_antar_lokasi}}</td>
                    <td>{{$hargaAntar->harga_antar_nominal}}</td>
                    <td>{{$hargaAntar->harga_antar_pertgl}}</td>
                    <td>{{$hargaAntar->harga_antar_status}}</td>
                    <td>
                      <button type="button" class="btn btn-danger btn-sm delete-harga-antar"
                      data-id="{{$hargaAntar->idharga_antar}}"><i class="fa fa-fw fa-trash"></i> Hapus</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Lokasi</th>
                  <th>Nominal</th>
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
          {{-- Tambah Harga Antar --}}
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Harga Antar</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ route('antar.store') }}" method="post">
                {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="harga_antar_nominal">Nominal Harga</label>
                  <input type="number" class="form-control" name="harga_antar_nominal" placeholder="Masukkan nominal harga">
                </div>
                <div class="form-group">
                  <label for="harga_antar_pertgl">Berlaku Per Tanggal</label>
                  <input type="date" class="form-control" name="harga_antar_pertgl" placeholder="Masukkan tanggal">
                </div>
                <div class="form-group">
                  <label for="harga_antar_lokasi">Lokasi Antar</label>
                  <select name="harga_antar_lokasi" class="form-control">
                    <option value="">Pilih Lokasi Antar</option>
                    <option value="tumpang">Tumpang</option>
                    <option value="malang">Malang</option>
                    <option value="batu">Batu</option>
                  </select>
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

    $(document).on('click', '.delete-harga-antar', function() {
      var id = $(this).data("id");
      var status = confirm("Are sure to delete it?");
      if(status){
        $.ajax({
          type: 'DELETE',
          url: '/admin/harga/antar/'+id,
          headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            $('#harga-antar-'+data.idharga_antar).remove();
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