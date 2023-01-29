<!DOCTYPE html>
<html lang="es">
  <head>
 <script src="https://apis.google.com/js/platform.js" async defer></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="{{ asset("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css")}}" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="{{ asset("https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js")}}"></script>
        <script type="text/javascript" src="{{ url("js/jquery-ui.js") }}" ></script>

        <link rel="stylesheet" href="{{asset("css/style_home.css")}}">
        <link href='https://fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href="{{ url("css/jquery-ui.css") }}" rel="stylesheet">


        <meta name="token" content="{{ csrf_token() }}"/>
        <script src="{{asset("js/jQuery-Autocomplete-master/src/jquery.autocomplete.js")}}"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta charset=”utf8″/>
    <meta name="author" content="Jobboard">
    
    <title>Soluciones Inmediatas</title>    

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('img/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}" type="text/css">    
    <link rel="stylesheet" href="{{ url('assets/css/jasny-bootstrap.min.css') }}" type="text/css">  
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap-select.min.css') }}" type="text/css">  
    <!-- Material CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/material-kit.css') }}" type="text/css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ url('assets/fonts/font-awesome.min.css') }}" type="text/css"> 
    <link rel="stylesheet" href="{{ url('assets/fonts/themify-icons.css') }}"> 

    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ url('assets/extras/animate.css') }}" type="text/css">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ url('assets/extras/owl.carousel.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/extras/owl.theme.css') }}" type="text/css">
    <!-- Rev Slider CSS -->
    <link rel="stylesheet" href="{{ url('assets/extras/settings.css') }}" type="text/css"> 
    <!-- Slicknav js -->
    <link rel="stylesheet" href="{{ url('assets/css/slicknav.css') }}" type="text/css">
    <!-- Main Styles -->
    <link rel="stylesheet" href="{{ url('assets/css/main.css') }}" type="text/css">
    <!-- Responsive CSS Styles -->
    <link rel="stylesheet" href="{{ url('assets/css/responsive.css') }}" type="text/css">
    
    <!-- Color CSS Styles  -->
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/colors/red.css') }}" media="screen" />


    
  </head>

  <body>  
   <script>
$(function () {
    $.ajaxSetup({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        }
    });

});
        </script>
    <!-- Menu ("header") -->
    @include('header')

    <!-- Contenido ("contect") -->
    @yield("content")

    <!-- Pie de pagina ("Footer") -->
    <footer>
      @include('footer')
    </footer>
    <!-- Footer Section End -->  
    
    <!-- Al cargar la pagina este es el stylo inicial -->
    <a href="#" class="back-to-top">
      <i class="ti-arrow-up"></i>
    </a>

    <div id="loading">
      <div id="loading-center">
        <div id="loading-center-absolute">
          <div class="object" id="object_one"></div>
          <div class="object" id="object_two"></div>
          <div class="object" id="object_three"></div>
          <div class="object" id="object_four"></div>
          <div class="object" id="object_five"></div>
          <div class="object" id="object_six"></div>
          <div class="object" id="object_seven"></div>
          <div class="object" id="object_eight"></div>
        </div>
      </div>
    </div>



    <!-- Fin stylo inicial de carga pagina -->
    
    <!-- Main JS  -->
   <script src="{{ url('https://www.google.com/recaptcha/api.js') }}" type="text/javascript" ></script>
    <script type="text/javascript" src="{{ url('assets/js/bootstrap.min.js') }}"></script>    
    <script type="text/javascript" src="{{ url('assets/js/material.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/material-kit.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/jquery.parallax.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/jquery.slicknav.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/main.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/jquery.counterup.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/waypoints.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/jasny-bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/form-validator.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/contact-form-script.js') }}"></script>    
   
    
    
  </body>
</html>