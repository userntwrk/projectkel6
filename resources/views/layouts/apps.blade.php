<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <title>Nayamul Catering</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{asset('css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('css/templatemo-sixteen.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.css')}}">


</head>

<body>
@include('sweet::alert')
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="/product"><h2>Nayamul <em>Catering</em></h2></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="/product">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#about">About Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#contact">Contact Us</a>
              </li>
              <li class="nav-item">
                <?php
                  $pesanan_utama = \App\Models\Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
                  if(!empty($pesanan_utama)){
                      $notif = \App\Models\PesananDetail::where('pesanan_id', $pesanan_utama->id)->count();
                  }
                  ?>
                  <a class="nav-link" href="{{ url('checkout') }}">
                    <i class="fa fa-shopping-cart"></i>
                      @if(!empty($notif))
                          <span class="badge badge-danger">{{ $notif }}</span>
                      @endif
                    </a>
               </li>
          </div>
        </div>
      </nav>
    </header>

    @yield('content')

    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="inner-content">
              <p>Copyright &copy; 2020

             <a rel="nofollow noopener" href="https://templatemo.com" target="_blank">Nayamul Catering Co., Ltd.</a></p>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>


    <!-- Additional Scripts -->
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/owl.js')}}"></script>
    <script src="{{asset('js/slick.js')}}"></script>
    <script src="{{asset('js/isotope.js')}}"></script>
    <script src="{{asset('js/accordions.js')}}"></script>

    <script language = "text/Javascript">
      cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
      function clearField(t){                   //declaring the array outside of the
      if(! cleared[t.id]){                      // function makes it static and global
          cleared[t.id] = 1;  // you could use true and false, but that's more typing
          t.value='';         // with more chance of typos
          t.style.color='#fff';
          }
      }
    </script>

    <script src="{{ asset('sweetalert2.all.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  </body>
</html>
