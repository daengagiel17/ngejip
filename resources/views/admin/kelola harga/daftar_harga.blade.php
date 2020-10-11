@extends('layouts.admin')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Data Harga <small>(Jeep changed, jeep default, antar, dan jemput)</small></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Kelola Data</a></li>
        <li class="active">Data Harga</li>
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
                  <th>Mulai tanggal</th>
                  <th>Sampai tanggal</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>                 
                  @foreach($hargaJeepChangeds as $hargaJeepChanged)
                  <tr id="jeep-changed-{{$hargaJeepChanged->idharga_jeep_changed}}">
                    <td>{{$hargaJeepChanged->harga_jeep_changed_nominal}}</td>
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

      <div class="row">
        <div class="col-xs-9">
          {{-- Harga Jeep Default --}}
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Daftar Harga Jeep Default</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Nominal</th>
                  <th>Berlaku per tanggal</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($hargaJeepDefaults as $hargaJeepDefault)
                  <tr id="jeep-default-{{$hargaJeepDefault->idharga_jeep_default}}">
                    <td>{{$hargaJeepDefault->harga_jeep_default_nominal}}</td>
                    <td>{{$hargaJeepDefault->harga_jeep_default_pertanggal}}</td>
                    <td>{{$hargaJeepDefault->harga_jeep_default_status}}</td>
                    <td>
                      <button type="button" class="btn btn-danger btn-sm delete-jeep-default" 
                      data-id="{{$hargaJeepDefault->idharga_jeep_default}}"><i class="fa fa-fw fa-trash"></i> Hapus</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Nominal</th>
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
          {{-- Tambah Harga Jeep Default --}}
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Harga Jeep Default</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ route('jeep-default.store') }}" method="post">
                {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="harga_jeep_default_nominal">Nominal Harga</label>
                  <input type="number" class="form-control" name="harga_jeep_default_nominal" placeholder="Masukkan nominal harga">
                </div>
                <div class="form-group">
                  <label for="harga_jeep_default_pertanggal">Berlaku Per Tanggal</label>
                  <input type="date" class="form-control" name="harga_jeep_default_pertanggal" placeholder="Masukkan tanggal">
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

      <div class="row">
        <div class="col-xs-9">
          {{-- Harga Harga Jemput --}}
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Daftar Harga Jemput</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example3" class="table table-bordered table-hover">
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
            <form action="{{ route('harga-jemput.store') }}" method="post">
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

      <div class="row">
        <div class="col-xs-9">
          {{-- Daftar Harga Antar --}}
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Daftar Harga Antar</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example4" class="table table-bordered table-hover">
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
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Harga Antar</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ route('harga-antar.store') }}" method="post">
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

      <div class="row">
          <div class="col-xs-9">
            {{-- Daftar Harga Tiket --}}
            <div class="box box-success">
              <div class="box-header">
                <h3 class="box-title">Daftar Harga Tiket</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="example5" class="table table-bordered table-hover">
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
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Tambah Harga Tiket</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form action="{{ route('harga-tiket.store') }}" method="post">
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
      $('#example2').DataTable()
      $('#example3').DataTable()
      $('#example4').DataTable()
      $('#example5').DataTable()
    })
  </script>
@endsection