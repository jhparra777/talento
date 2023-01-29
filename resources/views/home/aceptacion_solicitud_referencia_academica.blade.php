<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="token" content="{{ csrf_token() }}"/>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta http-equiv="content-type" content="text/html; charset=utf-8">

    {{-- Boostrap CSS --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

    {{-- Boostrap theme --}}
    <link rel="stylesheet" href="{{ asset("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css")}}" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

    {{-- Font --}}
    <link href='https://fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900' rel='stylesheet' type='text/css'>

    {{-- Style --}}
    <link rel="stylesheet" href="{{ asset("css/style_home.min.css") }}">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    
    {{-- JQuery UI css --}}
    <link href="{{ url("css/jquery-ui.min.css") }}" rel="stylesheet">

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/css/jasny-bootstrap.min.css') }}" type="text/css"> 
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap-select.min.css') }}" type="text/css">

    {{-- Font Awesome CSS --}}
    <link rel="stylesheet" href="{{ url('assets/fonts/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/fonts/themify-icons.min.css') }}">

    {{-- Animate CSS --}}
    <link rel="stylesheet" href="{{ url('assets/extras/animate.min.css') }}" type="text/css">

    {{-- Owl Carousel --}}
    <link rel="stylesheet" href="{{ url('assets/extras/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/extras/owl.theme.min.css') }}" type="text/css">

    {{-- Rev Slider CSS --}}
    <link rel="stylesheet" href="{{ url('assets/extras/settings.min.css') }}" type="text/css"> 

    {{-- Slicknav js --}}
    <link rel="stylesheet" href="{{ url('assets/css/slicknav.min.css') }}" type="text/css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ asset("https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js")}}"></script>

    <script src="https://apis.google.com/js/platform.js" async defer></script>
        
    <title>
        @if(isset($sitio->nombre))
            @if($sitio->nombre != "")
                {{$sitio->nombre }}
            @else
                Desarrollo
            @endif
        @else
            Desarrollo
        @endif
    </title>

    {{-- Favicon --}}
    @if(isset($sitio->favicon))
        @if($sitio->favicon != "")
            <link href="{{ url('configuracion_sitio') }}/{{ $sitio->favicon }}" rel="shortcut icon">
        @else
            <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
        @endif
    @else
        <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
    @endif
    <style>
        body { 
            font-family: helvetica, 'helvetica neue', arial, verdana, sans-serif !important;
            padding-top: 95px;
            background-color: #f1f1f1;
         }
        p{
            font-size: 12pt !important;
        }
        .navbar{
            min-height:75px !important;
        }
        .error{
            font-size: 10pt !important;
        }

        table > thead > tr > th, table > thead > tr > td,
        table > tbody > tr > th, table > tbody > tr > td{
            border:none !important;
        }
    </style>
</head>
<body> 
    <div class="modal" id="modal_success_view">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

    <div class="modal fade" id="modal_peq" >
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    
    <div class="modal" id="modal_success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header alert-info">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"><span class="fa fa-check-circle "></span> Confirmación</h4>
                </div>
                <div class="modal-body" id="texto"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
  
    <div class="modal fade" id="modal_gr" tabindex="-1" role="dialog" aria-labelledby="answerModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content"></div>
        </div>
    </div>
    
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

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <!-- El logotipo y el icono que despliega el menú se agrupan
            para mostrarlos mejor en los dispositivos móviles -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target=".navbar-ex1-collapse">
            <span class="sr-only">Desplegar navegación</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            @if($sitio->logo != null && $sitio->logo != "")
                <a class="navbar-brand" href="#">
                    <img height="50" src="{{asset('configuracion_sitio/'.$sitio->logo)}}" alt="logo">
                </a>
            @endif
        </div>

        <!-- Agrupar los enlaces de navegación, los formularios y cualquier
            otro elemento que se pueda ocultar al minimizar la barra -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-12">
                    @if(Session::has("mensaje_error"))
                        <div class="alert alert-danger" role="alert" style="border-left: 8px solid #E33441;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <div style="display: flex; align-items: center;">
                                <div>
                                    <b>
                                        <i class="fa fa-times-circle fa-2x" style="color:#E33441;"></i>
                                    </b>
                                </div>
                                <div style="padding-left:2em;">
                                    <b>
                                        {!! Session::get("mensaje_error") !!}
                                    </b>
                                </div>
                            </div>
                        </div>
                    @endif
                    <h2>Solicitud de referencia académica</h2>
                    <p>Buen día señores {{$referencia->institucion}}, el equipo de selección de {{$sitio->nombre}} se permiten solicitar la referencia del candidato: 
                    </p>
                    <div class="panel  panel-default" @if( in_array($referencia->verificado, [1,2]) ) style="border-color: #07F818;" @endif>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <b> Nombre:</b> 
                                        <br/>
                                        <span class="text-uppercase">{{$referencia->nombres}} {{$referencia->primer_apellido}} {{$referencia->segundo_apellido}}</span>
                                    </td>
                                    <td>
                                        <b>Identificación:</b> 
                                        <br/>
                                        {{$referencia->tipo_doc}} {{$referencia->numero_id}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Programa:</b> 
                                        <br/>
                                        {{$referencia->programa}}
                                    </td>
                                    <td>
                                        <b>Nivel académico:</b> 
                                        <br/>
                                        {{$referencia->nivel_estudio}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>Ciudad de estudio:</b> 
                                        <br/>
                                        {{$referencia->ciudad}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Fecha de inicio:</b> 
                                        <br/>
                                        {{$referencia->fecha_inicio}}
                                    </td>
                                    <td>
                                        <b>Fecha de terminación:</b> 
                                        <br/>
                                        {{$referencia->fecha_finalizacion}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Acta:</b> 
                                        <br/>
                                        {{$referencia->numero_acta}}
                                    </td>
                                    <td>
                                        <b>Folio:</b> 
                                        <br/>
                                        {{$referencia->numero_folio}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>Documentos soporte cargados por el candidato:</b>
                                        <br/>
                                        @foreach( $certificados as $i => $certificado)
                                            <a class="btn btn-link" title="Ver" target="_blank" href='{{route("view_document_url", encrypt("recursos_documentos/"."|".$certificado->documento->nombre_archivo."|".$certificado->documento->tipo_documento_id))}}' style="color: green;">
                                                <i class="fa fa-eye"> </i>
                                                Ver certificado {{$i+1}}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if( !in_array($referencia->verificado, [1,2]) )
                    <div class="alert alert-info" role="alert" style="border-left: 8px solid #1289EF; display: flex; align-items: center;">
                        <div>
                            <b>
                                <i class="fa fa-info-circle fa-2x" style="color:#1289EF;"></i>
                            </b>
                        </div>
                        <div style="padding-left:2em;">
                            <b>
                            Por favor ingrese los datos solicitados como referenciante, y si ratifica que la información es veraz y correcta por favor marque en el botón “Si” de lo contrario marque “No” e ingrese sus observaciones
                            </b>
                        </div>
                        
                    </div>
                    <div class="panel  panel-default">
                        <div class="panel-body" style="padding-top:30px;">
                            <form method="POST" action="{{route('admin.guarda_verificacion_referencia_estudio')}}" id="fr_solicitud_referencia">
                                {!! csrf_field() !!}
                                <input type="hidden" name="id" value="{{$referencia->id}}" />
                                <div class="row">
                                    <div class="col-12 col-md-6 form-group">
                                        <label for="inputEmail3" class="col-sm-12 control-label">Nombres y Apellidos <span class="text-danger">*</span>:</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="nombres" class="form-control" placeholder="Ingrese nombres y apellidos" required>
                                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres",$errors) !!}</p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 form-group">
                                        <label for="inputEmail3" class="col-sm-12 control-label">Cargo <span class="text-danger">*</span>:</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="cargo" class="form-control" placeholder="Ingrese cargo" required>
                                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo",$errors) !!}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-12 form-group">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" id="aprueba" class="btn btn-success btn-lg" name="aprobo" value="si">Si</button>
                                            <button type="button" id="no_aprueba" class="btn btn-danger btn-lg">No</button>
                                        </div>
                                    </div>
                                    <div class="mostrar col-12 col-md-12 form-group hide">
                                        <label for="inputEmail3" class="col-sm-12 control-label">Observaciones <span class="text-danger">*</span>:</label>
                                        <div class="col-sm-12">
                                            <textarea name="observaciones" class="form-control" rows="4" id="observaciones" placeholder="Ingrese observaciones"></textarea>
                                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
                                        </div>
                                    </div>

                                    <div class="mostrar col-12 col-md-12 form-group hide">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" id="no_aprueba" class="btn btn-primary btn-lg" name="aprobo" value="no">Guardar</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-success" role="alert" style="border-left: 8px solid #07F818; display: flex; align-items: center;">
                        <div>
                            <b>
                                <i class="fa fa-check-circle-o fa-2x" style="color:#07F818;"></i>
                            </b>
                        </div>
                        <div style="padding-left:2em;">
                            <b>
                                La referencia académica ya ha sido verificada.
                            </b>
                        </div>
                        
                    </div>
                    @endif
            </div>
        </div>
    </div>

    {{-- Main JS  --}}
    <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
    <script src="{{ url('https://www.google.com/recaptcha/api.js') }}" type="text/javascript" ></script>
    <script type="text/javascript" src="{{ url('assets/js/bootstrap.min.js') }}"></script>   
    <script type="text/javascript" src="{{ url('assets/js/jquery.parallax.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/jquery.slicknav.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/main.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/jquery.counterup.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/waypoints.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/jasny-bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/form-validator.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/contact-form-script.js') }}"></script> 
    <script type="text/javascript" src="{{ url('js/jquery-ui.js') }}" ></script>
    <script src="{{asset('js/jQuery-Autocomplete-master/src/jquery.autocomplete.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript">
    $(function(){
        @if(Session::has("mensaje_success") && $referencia->verificado == 1)
        Swal.fire({
            position: 'center',
            icon: 'info',
            title: '{!! Session::get("mensaje_success") !!}',
            showConfirmButton: false,
            timer: 1500
            });
        @endif

        $("#no_aprueba").click(function(){
            $(".mostrar").removeClass('hide')
            $("#observaciones").attr('required', true)
        })

        $("#aprueba").click(function(){
            $(".mostrar").addClass('hide')
            $("#observaciones").removeAttr('required')
        })
    })
    </script>
</body>
</html>