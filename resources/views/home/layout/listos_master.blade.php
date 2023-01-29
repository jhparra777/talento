<!DOCTYPE html>
<html>
<head>
	<title>
		@if(isset(FuncionesGlobales::sitio()->nombre))
            @if(FuncionesGlobales::sitio()->nombre != '')
                {!! ((FuncionesGlobales::sitio()->nombre)) !!} - Inicio
            @else
                Desarrollo | Inicio
            @endif
        @else
            Desarrollo | Inicio
        @endif
	</title>

	{{-- Favicon --}}
	@if(isset(FuncionesGlobales::sitio()->favicon))
        @if(FuncionesGlobales::sitio()->favicon != "")
            <link href="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->favicon)) !!}" rel="icon" type="image/x-icon">
        @else
            <link href="{{ url('img/favicon.png') }}" rel="icon" type="image/x-icon">
        @endif
    @else
        <link href="{{ url('img/favicon.png') }}" rel="icon" type="image/x-icon">
    @endif

	<meta charset="UTF-8">
	<meta name="token" content="{{ csrf_token() }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	{{-- Bootstrap --}}
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	
	{{-- CSS --}}
	<link type="text/css" href="{{ asset('assets/listos/css/font-awesome.css') }}" rel="stylesheet">
	
    @if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'http://listos.t3rsc.co')
        <link type="text/css" href="{{ asset('assets/listos/css/home-style.css') }}" rel="stylesheet">
    @elseif(route('home') == 'https://vym.t3rsc.co' || route('home') == 'http://vym.t3rsc.co')
        <link type="text/css" href="{{ asset('assets/listos/css/home-style-vym.css') }}" rel="stylesheet">
    @endif

	<link type="text/css" href="{{ asset('assets/listos/css/datepicker3.css') }}" rel="stylesheet">

	{{-- Font --}}
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
</head>
<body>
	{{-- Javascript --}}
	<script src="{{ asset('assets/js/jquery-3.4.1.js') }}"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<script src="{{ asset('assets/listos/js/bootstrap-datepicker.js') }}"></script>

	<script src="{{ asset('assets/listos/js/home-scripts.js') }}"></script>

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

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v6.0"></script>

	@yield('content')
</body>
</html>