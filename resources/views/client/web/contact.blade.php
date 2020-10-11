@extends('layouts.client')

@section('content')
    <div class="unit-5 bg-secondary">
      <div class="container text-center">
        <h2 class="mb-0">Contact</h2>
        <p class="mb-0 unit-6"><a href="{{route('home')}}">Home</a> <span class="sep">></span> <span>Contact</span></p>
      </div>
    </div>

    <div class="unit-5 bg-light">
      <div class="container">
        <div class="row d-flex contact-info">
          <div class="col-md-12 mb-4">
            <h2 class="h3" style="color: black;">Contact Information</h2>
          </div>
          <div class="w-100"></div>
          <div class="col-md-3">
            <p><span>Address:</span> 198 West 21th Street, Suite 721 New York NY 10016</p>
          </div>
          <div class="col-md-3">
            <p><span>Phone:</span> <a href="tel://085819910714">0858 1991 0714</a></p>
          </div>
          <div class="col-md-3">
            <p><span>Email:</span> <a href="mailto:ngejipmalang@gmail.com">ngejipmalang@gmail.com</a></p>
          </div>
          <div class="col-md-3">
            <p><span>Website</span> <a href="#">ngejip.com</a></p>
          </div>
        </div>
        
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row d-flex mb-5 contact-info">
          <div class="col-md-6 d-flex">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d370.0599325731721!2d112.58316615263601!3d-7.9194994791475795!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x8527353ac101c6e7!2sVilla+Biru+Abah+Ngali!5e0!3m2!1sen!2sid!4v1547985583795" width="600" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>    
          </div>
          <div class="col-md-6 order-md-last d-flex">
            <form action="#" class="col-md-12">
              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <input type="text" id="fullname" class="form-control" placeholder="Full Name">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <input type="email" id="email" class="form-control" placeholder="Email Address">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <input type="text" id="subject" class="form-control" placeholder="Enter Subject">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <textarea name="message" id="message" cols="30" rows="5" class="form-control" placeholder="Say hello to us"></textarea>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Send" class="btn btn-primary  py-2 px-4">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection