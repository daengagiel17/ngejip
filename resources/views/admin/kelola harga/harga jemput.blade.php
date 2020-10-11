@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Harga Jemput</h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Harga Jemput</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-9">
          {{-- Harga Harga Jemput --}}
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Daftar Harga Jemput</h3>
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
                  @foreach($hargaJemputs as $hargaJemput)
                  <tr id="harga-jemput-{{$hargaJemput->idharga_jemput}}">
                    <td>{{$hargaJemput->harga_jemput_lokasi}}</td>
                    <td>{{$hargaJemput->harga_jemput_nominal}}</td>
                    <td>{{$hargaJemput->harga_jemput_pertgl}}</td>
                    <td>{{$hargaJemput->harga_jemput_status}}</td>
                    <td>
                      <button type="button" class="btn btn-danger btn-sm delete-harga-jemput"
                      data-id="{{$hargaJemput->idharga_jemput}}"><i class="fa fa-fw fa-trash"></i> Hapus</button>
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
          {{-- Tambah Harga Jemput --}}
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Harga Jemput</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ route('jemput.store') }}" method="post">
                {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="harga_jemput_nominal">Nominal Harga</label>
                  <input type="number" class="form-control" name="harga_jemput_nominal" placeholder="Masukkan nominal harga">
                </div>
                <div class="form-group">
                  <label for="harga_jemput_pertgl">Berlaku Per Tanggal</label>
                  <input type="date" class="form-control" name="harga_jemput_pertgl" placeholder="Masukkan tanggal">
                </div>
                <div class="form-group">
                  <label for="harga_jemput_lokasi">Lokasi Jemput</label>
                  <select name="harga_jemput_lokasi" class="form-control">
                    <option value="">Pilih Lokasi Jemput</option>
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

    $(document).on('click', '.delete-harga-jemput', function() {
      var id = $(this).data("id");
      var status = confirm("Are sure to delete it?");
      if(status){
        $.ajax({
          type: 'DELETE',
          url: '/admin/harga/jemput/'+id,
          headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            $('#harga-jemput-'+data.idharga_jemput).remove();
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