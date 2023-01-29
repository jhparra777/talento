<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>{{ $sitio->nombre }} - T3RS</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Meta tag Keywords -->

    @if(isset($sitio->favicon))
        @if($sitio->favicon != "")
            <link href="{{ url('configuracion_sitio')}}/{{ $sitio->favicon }}" rel="shortcut icon">
        @else
            <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
        @endif
    @else
        <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
    @endif

    <!-- css files -->
    <link rel="stylesheet" href="https://demo.w3layouts.com/demos_new/template_demo/20-04-2017/classy_user_ui_kit-demo_Free/1464381552/web/css/style.css" type="text/css" media="all" /> <!-- Style-CSS --> 
    <link rel="stylesheet" href="https://demo.w3layouts.com/demos_new/template_demo/20-04-2017/classy_user_ui_kit-demo_Free/1464381552/web/css/monthly.css">  <!-- Calender-CSS -->
    <link rel="stylesheet" href="https://demo.w3layouts.com/demos_new/template_demo/20-04-2017/classy_user_ui_kit-demo_Free/1464381552/web/css/font-awesome.css"> <!-- Font-Awesome-Icons-CSS -->
    <!-- //css files -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- SmokeJS - CSS --}}
    <link rel="stylesheet" href="{{ asset('js/smoke/css/smoke.min.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- //online-fonts -->
    <style type="text/css">
        .signin-form, .top-grids, .top-grids-3 {
            width: 48% !important;
        }

        #signin p {
            text-align: justify;
        }

        .agile-wi {
            width: 85%!important;
        }

        .table-responsive table {
            width: 90%;
            margin-left: 5%;
        }

        @media screen and (max-width: 800px) {
            .agile-wi .signin-form{
                width: 100%!important;
            }
            .top-grids{
                margin: 3% auto 0%;
                width: 85%!important;
            }
        }

        #gum {
            padding: 1px 1px;
            border: #2455e8 2px solid;
            border-radius: 20px;
            max-width: 100%;
        }

        #recorded {
            padding: 1px 1px;
            border: #2455e8 2px solid;
            border-radius: 20px;
            max-width: 100%;
        }

        #video-guardado {
            padding: 1px 1px;
            border: #2455e8 2px solid;
            border-radius: 20px;
        }

        .swal-button--catch {
            background-color: indianred;
        }

        .swal-button--defeat {
            background-color: forestgreen;
        }

        .borde-rojo-2x {
            border: #961212 2px solid !important;
            border-radius: 20px !important;
        }

        #img-grabacion {
            position: absolute;
            margin: 30px;
            margin-top: 20px !important;
            display: none;
            z-index: 1;
            margin-left: 8%;
        }

        #timer-video-descripcion {
            display: none;
        }

        #timer-video-descripcion .timer-container {
            display:table;
            color:#0061f2;
            font-weight:bold;
            text-align:center;
            text-shadow:1px 1px 4px #999;
        }

        #timer-video-descripcion .timer-container div span {
            font-size:40px;
            padding:10px;
        }
    </style>
</head>
<body>
    <h1 class="agile-head">Video Prueba Idioma</h1>
    <div class="agile-wi">
        <!-- logIn Form -->
        <div class="signin-form">
            <form id="signin" action="#" method="post">
                <h3>Tips Prueba Idioma</h3>

                <p>
                  1.  Compruebe la funcionalidad de su equipo: aunque es el punto más básico, la tecnología puede fallar, por eso es importante hacerse las siguientes preguntas: ¿su equipo funciona correctamente? ¿Su Internet está activo y la señal es buena? para esto es importante hacer pruebas previamente. Si está en un equipo portátil, conecte un cable de alimentación de la batería o asegúrese de que está completamente cargada. También es recomendable utilizar un cable Ethernet y no la señal de Wifi, puesto que muchas veces por intermitencia puede caerse la conexión.
                </p>
                <p>
                  2.  Mire a la cámara: su primer instinto será mirar al entrevistador y no a la cámara. A pesar de parecer extraño estar mirando el pequeño punto de su Webcam, es importante hacerlo para crear una relación más cercana con el reclutador.
                </p>
                <p>
                  3.  Piense en el espacio a su alrededor: el secreto es hacer que su casa, o el lugar donde se encuentra para presentar la entrevista, parezca tan profesional como sea posible. No tenga un fondo que pueda distraer al entrevistador y asegúrese de que el espacio se encuentre debidamente ordenado. Pruebe diferentes opciones de iluminación hasta encontrar el que considere funciona mejor. Opte por una iluminación que no oscurezca la imagen, algo que sucederá si la luz está directamente detrás de usted.
                </p>
                <p>
                  4.  Minimice posibles interrupciones: es importante poner en silencio el celular, y en el caso de estar en casa, también el fijo.
                  Piense en cualquier otra cosa que pueda distraerlo durante su entrevista y programar todo para que esto no suceda. Cierre todas las páginas de Internet que puedan llamar su atención y desactive las alertas de correo electrónico. Si vive con otras personas, indíqueles que tendrá una entrevista para que no lo vayan a interrumpir.
                </p>
                <div class="clear"> </div>
            </form>
        </div>
    </div>
    <!-- //logIn Form -->

    <!-- Profile-form -->
    <div class="top-grids">
        <div class="profile-agile">
            <h2>Preguntas Video Prueba Idioma</h2>

            <h5 class="mt-4 ml-4 text-white">Estás por comenzar la prueba de idiomas, verás la pregunta cuando comiences el video</h5>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        @foreach($preguntas_prueba as $key => $pregu)
                            <tr>
                                <td>
                                    <p class="text-white"><strong>Pregunta #{{ ++$key }} </strong></p>
                                </td>

                                @if(\App\Models\PreguntasPruebaIdioma::respuestas_candidato_static($user_id, $pregu->id) == 0)
                                    <td align="center"><a class="btn btn-info responder_pregunta" name="responder" id="responder" data-pregunta_id="{{$pregu->id}}" >Responder</a>
                                    </td>
                                @else
                                    <td align="center">
                                        <a class="btn btn-success" disabled>Realizado</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="w3layouts"></div>
        </div>
    </div>
    <!-- //Profile-form -->
    <div class="clear"></div> 
    <!-- //calendar -->
    <div class="modal fade" id="modal_peque" tabindex="-1" role="dialog" aria-labelledby="modal_peque" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Responder Video Idioma</h5>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal_success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header alert-info">
                    <h4 class="modal-title">Confirmación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="texto"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal_danger">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header alert-danger">
                    <h4 class="modal-title">Advertencia</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="texto"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
     
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    {{-- SmokeJS --}}
    <script src="{{ asset('js/smoke/js/smoke.min.js') }}"></script>
    {{-- SmokeJS - Language --}}
    <script src="{{ asset('js/smoke/lang/es.min.js') }}"></script>

    <script>
      inicio_grabacion = false;

      $(function () {
          $(".responder_pregunta").on("click", function() {

             var pregu_id = $(this).data("pregunta_id");
             $("#modal_peque .modal-body").load(
                "{{route('responder_pregunta_idioma')}}",
                "pregu_id="+ pregu_id +"&user_id="+{{ $user_id }},
                function(response) {
                    $("#modal_peque").modal({ backdrop: 'static', keyboard: false });
                }
            );
          });
      });

      function mensaje_success(mensaje) {
          $("#modal_success #texto").html(mensaje);
          $("#modal_success").modal("show");
      }

      function mensaje_danger(mensaje) {
          $("#modal_danger #texto").html(mensaje);
          $("#modal_danger").modal("show");
      }
    </script>

</body>
</html>