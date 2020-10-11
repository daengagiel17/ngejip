@extends('layouts.client')

@section('content')
    <div class="py-5 bg-primary">
      <div class="container"> 
        <div class="row row-custom align-items-center">
          <div class="col-md-1"></div>
          <div class="col-md-10">
            @if ($errors->has('email'))
              <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <strong>Email ini telah terdaftar !</strong>
              </div>
            @endif
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 offset-md-1"> 
            <img src="images/book.png" alt="Book Now" style="width: 300px;">
              <!--<h2 class="text-white h4 font-weihgt-normal mb-3">Data Booking</h2>-->
              <!--<div class="bg-white p-4 rounded mb-3">-->
              <!--</div>-->
          </div>
          <div class="col-md-6">
            <h2 class="font-weight-bold text-white">Input Data Customer</h2>    
            <form action="{{route('register-otp')}}" method="POST">
              @csrf
              <input type="hidden" name="idotp" id="idotp" value="{{$data['id']}}">
              <input type="hidden" name="state" id="state" value="{{$state}}">
              <input type="hidden" name="no_hp_pemesan" id="no-hp-pemesan" value="{{$data['phone']['number']}}">
              <input type="text" name="nama_pemesan" id="nama-pemesan" class="form-control" placeholder="Masukkan nama" required><br>
              <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required><br>
              <button type="submit" class="btn btn-dark btn-block" style="height: 45px;">Daftar</button>
            </form>
          </div>
        </div>            
      </div>
    </div>
@endsection